<?php
include 'db.php'; // Sertakan file koneksi database
include 'fungsi_pengurangan_pemilih.php'; // Pastikan file ini berisi logika untuk mengurangi jumlah pemilih
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['isValid'], $_SESSION['tps_no'])) {
    $kandidatId = $conn->real_escape_string($_POST['id']);
    $isValid = $conn->real_escape_string($_POST['isValid']) == 'true' ? 1 : 0;
    $tpsNo = $_SESSION['tps_no'];

    // Cek jumlah pemilih tersisa sebelum proses voting
    $stmt = $conn->prepare("SELECT Jumlah_pemilih FROM jumlah_suara WHERE Metode = ?");
    $stmt->bind_param("s", $tpsNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Jumlah_pemilih'] <= 0) {
            echo json_encode(['success' => false, 'message' => "Suara total untuk TPS/KSK $tpsNo sudah habis dan tidak bisa lagi melakukan pemilihan."]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Data TPS tidak ditemukan.']);
        exit;
    }

    // Menyimpan suara jika masih ada kuota pemilih
    $query = "INSERT INTO suara (kandidat_id, is_valid, tps_no) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iis", $kandidatId, $isValid, $tpsNo);
        if ($stmt->execute()) {
            // Kurangi jumlah pemilih untuk TPS setelah suara berhasil disimpan
            if (updateJumlahPemilih($tpsNo, $conn)) {
                // Berhasil menyimpan suara dan mengurangi jumlah pemilih
                echo json_encode(['success' => true, 'message' => 'Suara berhasil disimpan.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengurangi jumlah pemilih.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan suara.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyiapkan statement.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Request tidak valid.']);
}

$conn->close();
?>

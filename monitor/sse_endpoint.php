<?php
// Atur header untuk SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Parameter koneksi database
$host = 'localhost'; // Host database
$username = 'root'; // Username database
$password = ''; // Password database
$database = 'k5'; // Nama database

// Buat koneksi ke database
$mysqli = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fungsi untuk mengirim data ke klien
function sendUpdate($data) {
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush();
    flush();
}

// Loop utama untuk mengirim update
while (true) {
    // Query untuk mengambil data terbaru
    $query = "SELECT kandidat.nama, 
                     SUM(CASE WHEN suara.is_valid = 1 THEN 1 ELSE 0 END) AS total_suara_sah,
                     SUM(CASE WHEN suara.is_valid = 0 THEN 1 ELSE 0 END) AS total_suara_tidak_sah
              FROM kandidat
              LEFT JOIN suara ON kandidat.id = suara.kandidat_id
              GROUP BY kandidat.nama";

    $result = $mysqli->query($query);

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
    }

    // Tentukan apakah suara notifikasi harus diputar
    // Ini bisa berdasarkan logika tertentu, misalnya perubahan jumlah suara
    $playSound = false; // Atur default sebagai false

    // Misalnya, kita menetapkan $playSound menjadi true jika ada perubahan
    // Ini hanya contoh, Anda harus menyesuaikannya dengan logika aktual Anda
    // Misalnya, membandingkan dengan data sebelumnya atau mengecek timestamp terakhir pembaruan

    // Kirim data ke klien
    sendUpdate(['data' => $data, 'playSound' => $playSound]);

    // Tunggu sebelum menjalankan query lagi
    sleep(5);
}

// Tutup koneksi database
$mysqli->close();
?>
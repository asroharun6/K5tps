<?php
// fungsi_pengurangan_pemilih.php

function updateJumlahPemilih($userTpsNo, $conn) {
    // Mengurangi jumlah pemilih
    $updateQuery = "UPDATE jumlah_suara SET Jumlah_pemilih = Jumlah_pemilih - 1 WHERE Metode = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("s", $userTpsNo);
    $stmt->execute();

    // Periksa apakah update berhasil dan jumlah pemilih tidak negatif
    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        // Jika gagal mengurangi atau tidak ada baris yang terpengaruh, return false
        return false;
    }
}

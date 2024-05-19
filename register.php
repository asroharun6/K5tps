<?php
include 'db.php'; // Sertakan file koneksi database

$message = ''; // Untuk menyimpan pesan kesalahan atau sukses

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = $conn->real_escape_string($_POST['name']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // Simpan password sebagai teks biasa
    $tps_no = $conn->real_escape_string($_POST['tps_no']);
    $ksk_no = $conn->real_escape_string($_POST['ksk_no']);

    // Cek apakah username sudah ada
    $checkUser = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();
    if ($result->num_rows > 0) {
        $message = "Username sudah digunakan, silakan pilih username lain.";
    } else {
        // Query untuk menambahkan pengguna baru
        $query = "INSERT INTO users (name, username, password, tps_no, ksk_no) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sssss", $name, $username, $password, $tps_no, $ksk_no);
            if ($stmt->execute()) {
                $message = "Registrasi berhasil. Silakan <a href='login.php'>login</a>.";
            } else {
                $message = "Terjadi kesalahan saat menyimpan data.";
            }
            $stmt->close();
        } else {
            $message = "Gagal menyiapkan statement.";
        }
    }
    $checkUser->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .register-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-bottom: 15px;
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Form Registrasi</h2>
        <?php if ($message): ?>
            <p class="message"><?= $message; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" id="name" name="name" placeholder="Nama Lengkap" required>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="text" id="tps_no" name="tps_no" placeholder="Nomor TPS">
            <input type="text" id="ksk_no" name="ksk_no" placeholder="Nomor KSK">
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

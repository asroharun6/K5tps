<?php
session_start();
include 'db.php'; // Pastikan file ini terhubung ke database Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Kata sandi yang dimasukkan pengguna

    // Query untuk mendapatkan data pengguna
    $query = "SELECT id, name, username, password, tps_no, ksk_no FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $userInfo = $result->fetch_assoc();
            // Verifikasi password (modifikasi di sini)
            if ($password === $userInfo['password']) { // Bandingkan secara langsung
                // Jika password cocok, simpan info pengguna ke dalam session
                $_SESSION['user_id'] = $userInfo['id'];
                $_SESSION['username'] = $userInfo['username'];
                $_SESSION['name'] = $userInfo['name'];
                $_SESSION['tps_no'] = $userInfo['tps_no']; // Simpan tps_no ke dalam session
                $_SESSION['ksk_no'] = $userInfo['ksk_no'];

                // Redirect pengguna ke halaman berikutnya
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Username atau password salah.";
            }
        } else {
            $error = "Pengguna tidak ditemukan.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body, html {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f4f4f4;
        }
        .container {
            min-height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .header {
            padding: 10px;
            text-align: center;
            background: #616973;
            color: white;
            font-size: 20px;
        }
        .login-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label, form input[type="text"], form input[type="password"], form button {
            margin-bottom: 20px;
        }
        form input[type="text"], form input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        form button {
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #004494;
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 0px 0;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="images/logo.png" alt="Logo" style="height: 80px;"> <!-- Sesuaikan path ke logo Anda -->
            <h3>QUICK COUNT</h3>
        </div>

        <div class="login-container">
            <div class="login-box">
                <h2>Login</h2>
                <form action="" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>

        <footer>
   
          <a href="https://info.flagcounter.com/maLx"><img src="https://s01.flagcounter.com/count2/maLx/bg_FFFFFF/txt_000000/border_CCCCCC/columns_3/maxflags_12/viewers_0/labels_0/pageviews_0/flags_0/percent_0/" alt="Flag Counter" border="0"></a>
        </footer>
    </div>
</body>
</html>

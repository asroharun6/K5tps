<?php
include '../db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['processAddCandidate'])) {
    $nama = $_POST['nama'];
    $partaiId = $_POST['partaiId'];
    $foto = $_FILES['foto']['name'];
    $fotoTmp = $_FILES['foto']['tmp_name'];

    // Validate and move the uploaded file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto);
    if (move_uploaded_file($fotoTmp, $target_file)) {
        $stmt = $conn->prepare("INSERT INTO kandidat (nama, partai_id, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nama, $partaiId, $foto);
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil disimpan.');</script>";
        } else {
            echo "<script>alert('Error: Data gagal disimpan.');</script>";
        }
    } else {
        echo "<script>alert('Error: Failed to upload photo.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container-user {
            margin: 20px auto;
            width: 90%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #2196F3;
            color: #fff;
        }
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
        }
        .table tbody tr {
            transition: background-color 0.3s;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #ddd;
        }
        .status-icon {
            font-size: 18px;
        }
        .completed {
            color: green;
        }
        .not-completed {
            color: orange;
        }
    </style>
<div class="container-user">
    <button class="add-button" onclick="showFormAddCandidate()">Tambah Kandidat</button>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Partai ID</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM kandidat";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["nama"]) . "</td>
                            <td>" . htmlspecialchars($row["partai_id"]) . "</td>
                            <td><img src='uploads/" . htmlspecialchars($row["foto"]) . "' height='50'></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Data tidak ada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div id="modalCandidat" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFormAddCandidate()">&times;</span>
        <p>Kandidat Baru</p>
        <form id="myForm" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama"><b>Nama</b></label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="partaiId"><b>Partai ID</b></label>
                <input type="text" id="partaiId" name="partaiId" required>
            </div>
            <div class="form-group">
                <label for="foto"><b>Foto</b></label>
                <input type="file" id="foto" name="foto" required>
            </div>
            <div class="button-group">
                <button class="submit-button" type="submit" name="processAddCandidate">Simpan</button>
                <button type="reset" class="reset-button">Reset</button>
                <button type="button" class="close-button" onclick="closeFormAddCandidate()">Tutup</button>
            </div>
        </form>
    </div>
</div>


<script>
    function showFormAddCandidate() {
        document.getElementById("modalCandidat").style.display = "block";
    }

    function closeFormAddCandidate() {
        document.getElementById("modalCandidat").style.display = "none";
    }
</script>
</body>
</html>
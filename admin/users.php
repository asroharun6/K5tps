<?php
    include '../db.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['processAddUsers'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $tpsNo = $_POST['tpsNo'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE tps_no = ?");
        $stmt->bind_param("s", $tpsNo);
        $stmt->execute();
        $resultCheck = $stmt->get_result();
        if ($resultCheck->num_rows > 0) {
            echo "
            <script>
                setTimeout(function() {
                    alert('No TPS sudah terdaftar');
                }, 500);
            </script>";
        }else{
            $sql = "INSERT INTO users (name, username, password, tps_no) VALUES ('$name', '$username', '$password', '$tpsNo')";
            
            if ($conn->query($sql) === TRUE) {
                echo "
                <script>
                    setTimeout(function() {
                        alert('Data berhasil disimpan.');
                    }, 500);
                </script>";
            } else {
                echo "
                <script>
                    setTimeout(function() {
                        alert('Error: Data gagal disimpan. Silakan coba lagi.');
                    }, 500);
                </script>";
            }
        }
    }
?>

<div class="container-user">
    <button class="add-button" onclick="showFormAddUser()">Tambah Baru</button>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>No TPS</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM users WHERE role = '0'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["username"] . "</td>
                                <td>" . $row["tps_no"] . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr>
                            <td colspan='3'>Data tidak ada</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFormAddUser()">&times;</span>
        <p>Pengguna, Tambah Baru</p>
        <br/><br/>
        <form id="myForm" action="" method="post">
            <div class="form-group">
                <label for="name"><b>Nama</b></label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="tpsNo"><b>No TPS</b></label>
                <input type="text" id="tpsNo" name="tpsNo" required>
            </div>
            <div class="form-group">
                <label for="password"><b>Password</b></label>
                <input type="text" id="password" name="password" required>
            </div>
            <div class="button-group">
                <button class="submit-button" type="submit" name="processAddUsers">Simpan</button>
                <button type="reset" class="reset-button">Reset</button>
                <button type="button" class="close-button" onclick="closeFormAddUser()">Tutup</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showFormAddUser() {
        document.getElementById("myModal").style.display = "block";
    }

    function closeFormAddUser() {
        document.getElementById("myModal").style.display = "none";
    }
</script>
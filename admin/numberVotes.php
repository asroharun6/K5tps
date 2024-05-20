<?php
    include '../db.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['processNumberOfVotes'])) {
        $jumlahPemilih = $_POST['jumlahPemilih'];
        $metode = $_POST['metode'];
        $lokasi = $_POST['lokasi'];
        $id = $_POST['id'];
        
        if($id != null){
            $sqlUpdate = "UPDATE jumlah_suara SET Jumlah_pemilih='$jumlahPemilih', Lokasi='$lokasi', Metode='$metode' WHERE id='$id'";

            if ($conn->query($sqlUpdate) === TRUE) {
                echo "
                <script>
                    setTimeout(function() {
                        alert('Data berhasil diperbarui.');
                    }, 500);
                </script>";
            } else {
                echo "
                <script>
                    setTimeout(function() {
                        alert('Error: Data gagal diperbarui. Silakan coba lagi.');
                    }, 500);
                </script>";
            }
        }else{
            $stmt = $conn->prepare("SELECT * FROM jumlah_suara WHERE Metode = ?");
            $stmt->bind_param("s", $metode);
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
                $sql = "INSERT INTO jumlah_suara (Jumlah_pemilih, Metode, Lokasi) VALUES ('$jumlahPemilih', '$metode', '$lokasi')";
                    
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
    }
?>

<div class="container-numberOfVotes">
    <button class="add-button" onclick="showFormAddNumber()">Tambah Baru</button>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>No TPS</th>
                <th>Lokasi</th>
                <th>Jumlah Pemilih</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM jumlah_suara";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td><button style='background-color: transparent; border: none; cursor:pointer;' class='edit-button' data-id='" . $row["id"] . "' onclick='openEditForm(" . $row["id"] . ")'><i class='fas fa-pen-to-square'></i></button></td>
                                <td>" . $row["Metode"] . "</td>
                                <td>" . $row["Lokasi"] . "</td>
                                <td>" . $row["Jumlah_pemilih"] . "</td>
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

<div id="modalNumberOfVotes" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFormAddNumber()">&times;</span>
        <p>Jumlah Suara, Tambah Baru</p>
        <br/><br/>
        <form id="formNumberOfVotes" action="" method="post">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
                <label for="jumlahPemilih"><b>Jumlah Pemilih</b></label>
                <input type="number" id="jumlahPemilih" name="jumlahPemilih" required>
            </div>
            <div class="form-group">
                <label for="metode"><b>No TPS</b></label>
                <select id="metode" name="metode" required>
                    <option value="">Pilih No TPS</option>
                    <?php
                        $sql = "SELECT tps_no FROM users WHERE role = '0'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $tps_no = $row["tps_no"];
                
                                echo "<option value='" . $tps_no . "'>" . $tps_no . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="lokasi"><b>Lokasi</b></label>
                <input type="text" id="lokasi" name="lokasi" required>
            </div>
            <div class="button-group">
                <button class="submit-button" type="submit" name="processNumberOfVotes">Simpan</button>
                <button type="reset" class="reset-button">Reset</button>
                <button type="button" class="close-button" onclick="closeFormAddNumber()">Tutup</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showFormAddNumber() {
        document.getElementById("modalNumberOfVotes").style.display = "block";
    }

    function closeFormAddNumber() {
        document.getElementById("modalNumberOfVotes").style.display = "none";
    }

    function openEditForm(id) {
        var row = document.querySelector(`button[data-id='${id}']`).closest('tr');
        var tpsNo = row.cells[1].innerText;
        var lokasi = row.cells[2].innerText;
        var jumlahPemilih = row.cells[3].innerText;

        document.getElementById('id').value = id;
        document.getElementById('jumlahPemilih').value = jumlahPemilih;
        document.getElementById('metode').value = tpsNo;
        document.getElementById('lokasi').value = lokasi;

        showFormAddNumber();
    }
</script>
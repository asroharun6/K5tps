<?php
include '../db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Handle Delete Operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deleteSql = "DELETE FROM kandidat WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "<script>alert('Data berhasil dihapus.'); window.location.href='your_current_page.php';</script>";
}
?>

<div class="container-user">
    <button class="add-button" onclick="window.location.href='add_kandidat.php'">Tambah Kandidat</button>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Partai ID</th>
                <th>Foto</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM kandidat";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["nama"] . "</td>
                            <td>" . $row["partai_id"] . "</td>
                            <td><img src='uploads/" . $row["foto"] . "' height='50'></td>
                            <td>
                                <button onclick=\"window.location.href='edit_kandidat.php?id=" . $row['id'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Apakah Anda yakin ingin menghapus data ini?')) window.location.href='your_current_page.php?delete=" . $row['id'] . "'\">Delete</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Your existing script
</script>

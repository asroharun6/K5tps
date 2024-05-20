<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Suara</title>
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
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 20px;
        }
        .pagination li {
            padding: 10px;
            background-color: #f0f0f0;
            margin: 5px;
            cursor: pointer;
        }
        .pagination li.active {
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-user">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kandidat ID</th>
                    <th>Timestamp</th>
                    <th>Valid</th>
                    <th>No TPS</th>
                    <th>No KSK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../db.php'; // Pastikan lokasi file ini benar
                $limit = 5; // jumlah data per halaman
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // mendapatkan halaman saat ini
                $start = ($page - 1) * $limit; // menentukan data awal untuk halaman saat ini
                $no = $start + 1; // nomor urut data awal

                $countSql = "SELECT COUNT(*) AS total FROM suara";
                $countResult = $conn->query($countSql);
                $totalCount = $countResult->fetch_assoc()['total'];

                $totalPages = ceil($totalCount / $limit);
                $sql = "SELECT id, kandidat_id, `timestamp`, is_valid, tps_no, ksk_no FROM suara LIMIT $start, $limit";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>$no</td>
                                <td>" . $row["kandidat_id"] . "</td>
                                <td>" . $row["timestamp"] . "</td>
                                <td>" . ($row["is_valid"] ? 'Yes' : 'No') . "</td>
                                <td>" . $row["tps_no"] . "</td>
                                <td>" . $row["ksk_no"] . "</td>
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="<?= ($page == $i) ? 'active' : ''; ?>">
                    <a href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</body>
</html>

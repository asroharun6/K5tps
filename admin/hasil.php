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
</head>
<body>
    <div class="container-user">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah Terhitung</th>
                    <th>Suara Sah</th>
                    <th>Tidak Sah</th>
                    <th>Suara Sisa</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../db.php'; // Pastikan lokasi file ini benar
                $sql = "SELECT
                        users.name AS Metode,
                        COUNT(*) AS JumlahSuaraTerhitung,
                        SUM(CASE WHEN s.is_valid = 1 THEN 1 ELSE 0 END) AS total_suara_sah,
                        SUM(CASE WHEN s.is_valid = 0 THEN 1 ELSE 0 END) AS total_suara_tidak_sah,
                        jumlah_suara.Jumlah_pemilih AS SuaraPerMetode,
                        (SUM(CASE WHEN s.is_valid = 1 THEN 1 ELSE 0 END) + SUM(CASE WHEN s.is_valid = 0 THEN 1 ELSE 0 END) + jumlah_suara.Jumlah_pemilih ) AS Total_Suara_Terhitung,
                        CASE 
                            WHEN (COUNT(*) > 0 AND (SUM(CASE WHEN s.is_valid = 1 THEN 1 ELSE 0 END) + SUM(CASE WHEN s.is_valid = 0 THEN 1 ELSE 0 END) + jumlah_suara.Jumlah_pemilih) > 0 AND jumlah_suara.Jumlah_pemilih > 0) THEN 'NotCompleted'
                            ELSE 'Completed'
                        END AS StatusPekerjaan
                    FROM suara AS s
                    INNER JOIN kandidat AS k ON s.kandidat_id = k.id
                    INNER JOIN users ON s.tps_no = users.tps_no
                    INNER JOIN jumlah_suara ON users.tps_no = jumlah_suara.Metode
                    GROUP BY s.tps_no
                    ORDER BY users.name";
                
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $statusClass = $row["StatusPekerjaan"] === "Completed" ? "completed" : "not-completed";
                        $icon = $row["StatusPekerjaan"] === "Completed" ? "<i class='fas fa-check-circle $statusClass'></i>" : "<i class='fas fa-times-circle $statusClass'></i>";
                        echo "<tr>
                                <td>" . $row["Metode"] . "</td>
                                <td>" . $row["JumlahSuaraTerhitung"] . "</td>
                                <td>" . $row["total_suara_sah"] . "</td>
                                <td>" . $row["total_suara_tidak_sah"] . "</td>
                                <td>" . $row["SuaraPerMetode"] . "</td>
                                <td>" . $row["Total_Suara_Terhitung"] . "</td>
                                <td class='status-icon'>$icon</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

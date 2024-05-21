<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data_suara.csv');

include '../db.php'; // Pastikan lokasi file ini benar

$output = fopen("php://output", "w");
fputcsv($output, array('ID', 'Kandidat ID', 'Timestamp', 'Valid', 'No TPS', 'No KSK'));

$query = "SELECT id, kandidat_id, `timestamp`, is_valid, tps_no, ksk_no FROM suara";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>

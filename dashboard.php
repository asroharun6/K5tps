<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userTpsNo = $_SESSION['tps_no']; // Ambil TPS pengguna dari session

// Query untuk mengambil jumlah pemilih berdasarkan TPS pengguna
$jumlahPemilihQuery = "SELECT Jumlah_pemilih FROM jumlah_suara WHERE Metode = ?";
$stmt = $conn->prepare($jumlahPemilihQuery);
$stmt->bind_param("s", $userTpsNo);
$stmt->execute();
$jumlahPemilihResult = $stmt->get_result();
$jumlahPemilihRow = $jumlahPemilihResult->fetch_assoc();
$jumlahPemilih = isset($jumlahPemilihRow['Jumlah_pemilih']) ? $jumlahPemilihRow['Jumlah_pemilih'] : 'Data tidak ditemukan';

// Update query untuk kandidat
$kandidatQuery = "SELECT kandidat.id, kandidat.nama, kandidat.foto, 
                  SUM(CASE WHEN suara.is_valid = 1 THEN 1 ELSE 0 END) AS total_suara_sah,
                  SUM(CASE WHEN suara.is_valid = 0 THEN 1 ELSE 0 END) AS total_suara_tidak_sah
                  FROM kandidat 
                  LEFT JOIN suara ON kandidat.id = suara.kandidat_id AND suara.tps_no = ?
                  GROUP BY kandidat.id";
$stmt = $conn->prepare($kandidatQuery);
$stmt->bind_param("s", $userTpsNo);
$stmt->execute();
$kandidatResult = $stmt->get_result();

// Update query serupa untuk partai
$partaiQuery = "SELECT partai.id, partai.nama, 
                SUM(CASE WHEN suara_partai.is_valid = 1 THEN 1 ELSE 0 END) AS total_suara_sah,
                SUM(CASE WHEN suara_partai.is_valid = 0 THEN 1 ELSE 0 END) AS total_suara_tidak_sah
                FROM partai 
                LEFT JOIN suara_partai ON partai.id = suara_partai.partai_id AND suara_partai.tps_no = ?
                GROUP BY partai.id";
$stmt = $conn->prepare($partaiQuery);
$stmt->bind_param("s", $userTpsNo);
$stmt->execute();
$partaiResult = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan Umum</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
     .bg-light {
    background-color: rgb(170 178 187 / 35%) !important;
}
        }
        .container {
            background-color: white;
            padding: 0px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 0px;
        }
        .navbar {
            margin-bottom: 16px;
            box-shadow: 0 2px 6px #3b3e43;
        }
        .navbar-brand {
            font-weight: bold;
        }
   .navbar-text {
    font-size: 0.9rem;
    margin-right: -11px;
    background: #fffefe00;
    border-radius: 0px;
    padding: 5px;
    box-shadow: inset 0px -1px 20px 20px #d39e0000;
}
        /* Menambahkan style untuk mengatur link logout */
        .logout-link {
            margin-left: auto; /* Mendorong link ke kanan */
        }
    </style>
    
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="dashboard.php">WELCOME, <?= htmlspecialchars($_SESSION['name']); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Beranda <span class="sr-only">(current)</span></a>

                <!-- Menambahkan kelas logout-link untuk mengatur posisi -->
                <a class="nav-item nav-link logout-link" href="logout.php">Logout</a>
            </div>
             </div>
                <p class="navbar-brand">
        | Jumlah Pemilih Tersisa di TPS Anda: </p>
                <span class="navbar-text"><strong><h3 style="display: inline;"><b style="
    color: #181817;
    background: #fbfff1;
    border-radius: 10px;
"><?= $jumlahPemilih; ?></b></h3></strong>
                </span>
       
    </nav>

    

    
    
   
    <div class="row">
        <?php while ($row = $kandidatResult->fetch_assoc()): ?>
            <div class="col-md-4" id="card-kandidat-<?= $row['id']; ?>">
                <div class="card">
                    <img src="images/<?= $row['foto']; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']); ?>">
                    <div class="card-body">
                        <p>Total Suara Sah: <span style="background-color: #00800036;font-size: 25px;font-weight: 800;border-radius: 18px;"><?= $row['total_suara_sah']; ?></span></p>
                        
                             <p>Total Suara Tidak Sah: <span style="background-color: #ff00003d;font-size: 25px;font-weight: 800;border-radius: 18px;"><?= $row['total_suara_tidak_sah']; ?></span></p>
                        
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" onClick="submitVote('kandidat', <?= $row['id']; ?>, true)">Vote Sah</button>
                              <button class="btn btn-danger" onClick="submitVote('kandidat', <?= $row['id']; ?>, false)">Vote Tidak Sah</button>
                        </div>
                    </div>
                 
                </div>
            </div>
        <?php endwhile; ?>
    </div>



    </div>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
function submitVote(type, id, isVoteValid) {
    const voteConfirmation = isVoteValid ? "Apakah Anda yakin ingin memberikan suara sah?" : "Apakah Anda yakin ingin memberikan suara tidak sah?";
    if (!confirm(voteConfirmation)) {
        return; // Jika pengguna membatalkan konfirmasi, hentikan fungsi
    }

    const cardSelector = `#card-${type}-${id}`;
    $(cardSelector + ' .card-body').prepend('<div class="spinner"></div>');

    // Sesuaikan URL berdasarkan tipe yang dipilih (kandidat atau partai)
    const url = type === 'kandidat' ? "submit_vote.php" : "submit_vote_partai.php";

    $.ajax({
        type: "POST",
        url: url,
        data: { id: id, isValid: isVoteValid },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.success) {
                // Pembaruan halaman untuk menampilkan data terbaru
                location.reload(true);
            } else {
                // Hapus spinner jika gagal
                $(cardSelector + ' .spinner').remove();
            }
        },
        error: function() {
            alert("Terjadi kesalahan saat menghubungi server.");
            // Hapus spinner jika terjadi error
            $(cardSelector + ' .spinner').remove();
        }
    });
}

</script>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Script JavaScript Anda di sini
</script>

</body>
</html>

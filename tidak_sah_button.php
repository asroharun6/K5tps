<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote Tidak Sah</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .btn-tidak-sah {
            padding: 10px 20px;
            background-color: #dc3545; /* Warna merah untuk indikasi 'tidak sah' */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-transform: uppercase; /* Membuat teks menjadi huruf kapital */
            font-weight: bold;
            letter-spacing: 0.05rem;
        }

        .btn-tidak-sah:hover {
            background-color: #c82333; /* Warna sedikit lebih gelap saat di-hover */
        }

        .btn-tidak-sah:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        }

        /* Style untuk spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, .1);
            border-top-color: #dc3545;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            position: fixed;
            left: 50%;
            top: 50%;
            z-index: 1000;
            display: none; /* Sembunyikan spinner sampai dibutuhkan */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<!-- Menggunakan class btn-tidak-sah untuk styling tombol vote tidak sah -->
<button class="btn-tidak-sah" onclick="submitVote('kandidat', 4, false)">Vote Tidak Sah</button>

<div class="spinner"></div> <!-- Spinner untuk indikasi proses loading -->

<script>
function submitVote(type, id, isVoteValid) {
    const voteConfirmation = isVoteValid ? "Apakah Anda yakin ingin memberikan suara sah?" : "Apakah Anda yakin ingin memberikan suara tidak sah?";
    if (!confirm(voteConfirmation)) {
        return; // Jika pengguna membatalkan konfirmasi, hentikan fungsi
    }

    $('.spinner').show(); // Menampilkan spinner

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
                $('.spinner').hide();
            }
        },
        error: function() {
            alert("Terjadi kesalahan saat menghubungi server.");
            // Hapus spinner jika terjadi error
            $('.spinner').hide();
        }
    });
}
</script>

</body>
</html>

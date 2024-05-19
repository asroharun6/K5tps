<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilihan Umum</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Dashboard Pemilihan Umum</h1>
        <button id="enable-sound">Aktifkan Notifikasi Suara</button>
        <div class="charts-container">
            <div class="chart">
                <h2>Bar Chart: Suara Sah vs Tidak Sah</h2>
                <canvas id="barChart"></canvas>
            </div>
            <div class="chart">
                <h2>Daftar Kandidat dan Suara</h2>
                <table id="candidateList">
                    <thead>
                        <tr>
                            <th>Nama Kandidat</th>
                            <th>Suara Sah</th>
                            <th>Suara Tidak Sah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Baris kandidat akan ditambahkan di sini -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th id="totalValidVotes">0</th>
                            <th id="totalInvalidVotes">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <audio id="audio-element" src="notification.wav" preload="auto"></audio>

    <script src="dashboard.js"></script>
</body>
</html>

document.addEventListener('DOMContentLoaded', function() {
    let previousData = {}; // Mengubah ini menjadi objek untuk menyimpan total suara sebelumnya

    const audioElement = document.getElementById('audio-element');
    let soundEnabled = false; // Awalnya suara tidak aktif

    // Mengaktifkan suara
    document.getElementById('enable-sound').addEventListener('click', function() {
        soundEnabled = true;
        audioElement.play().then(() => {
            console.log("Audio unlocked");
        }).catch(error => {
            console.error("Failed to unlock audio:", error);
        });
        this.style.display = 'none'; // Sembunyikan tombol setelah diaktifkan
    });

    let barChart; // Hanya menggunakan satu grafik (barChart)

    // Fungsi untuk memperbarui grafik batang dan tabel kandidat
    function updateCharts(data) {
        const ctxBar = document.getElementById('barChart').getContext('2d');

        if (!barChart) {
            barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [
                        { label: 'Suara Sah', data: [], backgroundColor: 'green' },
                        { label: 'Suara Tidak Sah', data: [], backgroundColor: 'red' }
                    ]
                },
                options: { scales: { y: { beginAtZero: true } } }
            });
        }

        barChart.data.labels = data.map(item => item.nama);
        barChart.data.datasets[0].data = data.map(item => item.total_suara_sah);
        barChart.data.datasets[1].data = data.map(item => item.total_suara_tidak_sah);
        barChart.update();

        updateCandidateTable(data);
    }

    function updateCandidateTable(candidates) {
        const tableBody = document.getElementById('candidateList').querySelector('tbody');
        tableBody.innerHTML = ''; // Bersihkan konten sebelumnya

        let totalValidVotes = 0;
        let totalInvalidVotes = 0;

        candidates.forEach(candidate => {
            const row = tableBody.insertRow();
            row.insertCell(0).textContent = candidate.nama;
            row.insertCell(1).textContent = candidate.total_suara_sah.toLocaleString();
            row.insertCell(2).textContent = candidate.total_suara_tidak_sah.toLocaleString();

            totalValidVotes += parseInt(candidate.total_suara_sah, 10);
            totalInvalidVotes += parseInt(candidate.total_suara_tidak_sah, 10);
        });

        document.getElementById('totalValidVotes').textContent = totalValidVotes.toLocaleString();
        document.getElementById('totalInvalidVotes').textContent = totalInvalidVotes.toLocaleString();
    }

    // Mendengarkan data baru dari EventSource
    const eventSource = new EventSource('sse_endpoint.php');
    eventSource.onmessage = function(event) {
        const newData = JSON.parse(event.data);

        // Membandingkan total suara sah sekarang dengan sebelumnya
        const newTotalSuaraSah = newData.data.reduce((acc, item) => acc + item.total_suara_sah, 0);
        if (newTotalSuaraSah > (previousData.totalSuaraSah || 0)) {
            playSound();
        }

        // Memperbarui data suara sebelumnya
        previousData.totalSuaraSah = newTotalSuaraSah;

        updateCharts(newData.data);
    };

    function playSound() {
        if (soundEnabled && audioElement) {
            audioElement.play().catch(error => {
                console.error("Autoplay was prevented:", error);
            });
        }
    }
});

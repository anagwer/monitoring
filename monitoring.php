<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <!-- Navigation -->
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">
        
    </main><!-- End #main -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const data = <?php echo json_encode($data); ?>;

    data.forEach((item, index) => {
        const ctx = document.getElementById(`pieChart${index}`).getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [item.nm_kategori, 'Sisa Anggaran'],
                datasets: [{
                    data: [
                        Math.round(item.persen * 100),
                        Math.round((100 - item.persen) * 100)
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', // Color for percentage
                        'rgba(223, 223, 223, 0.91)'  // Color for remaining budget
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(223, 223, 223, 0.91)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: `Persentase Anggaran untuk ${item.nm_kategori}`
                    }
                }
            }
        });
    });
    </script>

    <?php include('footer.php'); ?>
    <?php include('script.php'); ?>
</body>
</html>

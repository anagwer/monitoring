<?php include ('session.php');?>
<?php include ('head.php');?>


<body>
    <!-- Navigation -->
    <?php include ('side_bar.php');?>

  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row"><?php 
           $hasil =date('Y');?>
        <!-- Left side columns -->
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah Kategori<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM kategori");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah Sub Kategori<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM sub_kategori");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah anggaran<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM anggaran");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <div class="col-lg-3">
            <!-- Info Card -->
            <div class="card text-center p-3"  style="padding:2%;height:125px;">
                <h3>Jumlah detail anggaran<br><b><?php 
                    $query = $conn->query("SELECT COUNT(*) as jml FROM detail_anggaran");
                    $row = $query->fetch_array();
                    echo $row['jml'];?></b></h3>
            </div><!-- End Sales Card -->
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="mt-3 text-center"><b>Data Monitoring</b></h1>
                            <!-- Print Button -->
              <form method="post" enctype="multipart/form-data">
                  <div class="row">
                      <div class="col-6">
                          <input type="date" class="form-control" name="tgl1">
                      </div>
                      <div class="col-6">
                          <input type="date" class="form-control" name="tgl2">
                      </div>
                  </div>
                  <br>
                  <button type="submit" name="proses" class="btn btn-success" style="float: right;">Print</button>
              </form>

              <?php
              if (isset($_POST['proses'])) {
                  $tgl1 = $_POST['tgl1'];
                  $tgl2 = $_POST['tgl2'];
              ?>
              <script>
                  function printNota() {
                      var printWindow = window.open('print_monitoring.php?tgl1=<?php echo $tgl1 ?>&tgl2=<?php echo $tgl2 ?>');
                      printWindow.onload = function() {
                          printWindow.print();
                          printWindow.onafterprint = function() {
                              printWindow.close();
                          };
                      };
                  }
                  printNota();
              </script>
              <?php } ?><br><br>
              

<div class="row">
    <div class="col-12">
        
        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Jenis Kategori</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Target</th>
                        <th scope="col">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                require 'dbcon.php';
                $no = 1;

                // Array untuk menyimpan data dari database
                $data = [];

                // Query untuk mengambil data untuk ditampilkan data di tabel
                $query = $conn->query("SELECT kategori.*, sub_kategori.*, 
                                        SUM(detail_anggaran.total) AS jml_total
                                        FROM kategori 
                                        JOIN sub_kategori ON sub_kategori.id_kategori = kategori.id_kategori
                                        JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                        JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                                        WHERE detail_anggaran.status='Acc'
                                        GROUP BY kategori.id_kategori");
                require 'dbcon.php';
                $no = 1;

                // Array untuk menyimpan data dari database
                $data = [];

                // Kueri untuk mengambil data
                $query = $conn->query("SELECT kategori.*, sub_kategori.*, 
                        SUM(detail_anggaran.total) AS jml_total
                        FROM kategori 
                        JOIN sub_kategori ON sub_kategori.id_kategori = kategori.id_kategori
                        JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                        JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                        WHERE detail_anggaran.status='Acc'
                        GROUP BY kategori.id_kategori");

                // Simpan hasil query ke dalam array
                while ($row = $query->fetch_array()) {
                    $hasil = $row['jml_total'] / $row['target'] * 100;
                    $data[] = [
                        'no' => $no,
                        'jns_kategori' => $row['jns_kategori'],
                        'id_kategori' => $row['id_kategori'],
                        'nm_kategori' => $row['nm_kategori'],
                        'target' => $row['target'],
                        'jml_total' => $row['jml_total'],
                        'persen' => $hasil
                    ];
                }

                // Insertion Sort untuk mengurutkan 'persen'
                for ($i = 1; $i < count($data); $i++) {
                    $key = $data[$i];
                    $j = $i - 1;
                    while ($j >= 0 && $data[$j]['persen'] > $key['persen']) {
                        $data[$j + 1] = $data[$j];
                        $j--;
                    }
                    $data[$j + 1] = $key;
                }

                            // Menampilkan data setelah diurutkan
                            foreach ($data as $row) {
                                echo "<tr>
                                        <th scope='row'>{$no}</th>
                                        <td>{$row['jns_kategori']}</td>
                                        <td>{$row['nm_kategori']}</td>
                                        <td>Rp. " . number_format($row['target'], 0, ",", ".") . "</td>
                                        <td>Rp. " . number_format($row['jml_total'], 0, ",", ".") . "</td>
                                    </tr>";
                                    $no++;
                            }
                ?>
                </tbody>
                </table>
            </div>
            <!-- End Table with stripped rows -->
        <h2 class="mt-3 mb-2 text-center"><b>Progress Anggaran Per Kategori</b></h2>
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-6">
                    <input type="date" class="form-control" name="tgl1">
                </div>
                <div class="col-6">
                    <input type="date" class="form-control" name="tgl2">
                </div>
            </div>
            <br>
            <button type="submit" name="monitoring" class="btn btn-primary" style="float: right;">Tampilkan</button><br>
        </form>
        <?php

        
		if (isset($_POST['monitoring'])) {
        $tgl1 = $_POST['tgl1'];
        $tgl2 = $_POST['tgl2'];
        $bool = false;
        foreach ($data as $row) { 
            // Set id_kategori untuk dipanggil ditombol
            $id_kategori = $row['id_kategori']; 
        ?>
            <div class='mb-3'>
                <h5><?php echo $row['nm_kategori']; ?></h5>
                <a rel="tooltip" title="Lihat" id="<?php echo $id_kategori ?>" href="#lihat<?php echo $id_kategori; ?>" data-toggle="modal">
                    <div class='progress'>
                        <div class='progress-bar bg-primary' role='progressbar' style="width: <?php echo $row['persen'] . '%';?>" aria-valuenow="<?php echo $row['persen']; ?>" aria-valuemin="0" aria-valuemax="100">
                            <?php echo number_format($row['persen'], 2, ",", ".") . "%";?>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Modal: -->
            <div class="modal fade" id="lihat<?php echo $id_kategori; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Monitoring <?php echo $row['nm_kategori']; ?></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>                        
                        <div class="modal-body">
                            <?php 
                            $result1 = mysqli_query($conn, "SELECT sub_kategori.*, SUM(detail_anggaran.total) AS jml_total, anggaran.id_anggaran
                                FROM sub_kategori
                                JOIN kategori ON kategori.id_kategori = sub_kategori.id_kategori
                                JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                                WHERE sub_kategori.id_kategori = '$id_kategori' and
                                detail_anggaran.status='Acc' and
                                detail_anggaran.tgl_pesan between '$tgl1' and '$tgl2'
                                GROUP BY sub_kategori.id_sub_kategori");
                        
                            $total = 0;
                            $data1 = [];
                        
                            // Mengambil data dari query pertama dan menghitung total
                            while ($hsl = mysqli_fetch_array($result1)) {
                                $total += floatval($hsl['jml_total']);  // Konversi ke float untuk menghindari kesalahan
                            }
                        
                            if ($total > 0) { // Hindari pembagian oleh nol
                                $result2 = mysqli_query($conn, "SELECT sub_kategori.*, SUM(detail_anggaran.total) AS jml_total, anggaran.id_anggaran
                                    FROM sub_kategori
                                    JOIN kategori ON kategori.id_kategori = sub_kategori.id_kategori
                                    JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                    JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                                    WHERE sub_kategori.id_kategori = '$id_kategori' and
                                    detail_anggaran.status='Acc' and
                                    detail_anggaran.tgl_pesan between '$tgl1' and '$tgl2'
                                    GROUP BY sub_kategori.id_sub_kategori");
                        
                                // Menghitung persen
                                while ($row1 = mysqli_fetch_array($result2)) {
                                    $id_anggaran = $row1['id_anggaran'];
                                    $query = $conn->query("SELECT SUM(detail_anggaran.total) AS ttl FROM detail_anggaran WHERE id_anggaran = '$id_anggaran' and status='Acc'");
                                    $query_row = $query->fetch_array();
                        
                                    // Pastikan query_row['ttl'] tidak kosong atau 0
                                    $hasil = ($query_row['ttl'] > 0) ? (floatval($query_row['ttl']) / $total) * 100 : 0;
                                    $row1['persen'] = $hasil;
                        
                                    // Menyimpan data ke dalam array $data1
                                    $data1[] = [
                                        'nm_sub_kategori' => $row1['nm_sub_kategori'],
                                        'jml_total' => $row1['jml_total'],
                                        'id_anggaran' => $row1['id_anggaran'],
                                        'persen' => $hasil
                                    ];
                                    // Insertion Sort untuk mengurutkan 'persen'
                                    for ($i = 1; $i < count($data1); $i++) {
                                        $key = $data1[$i];
                                        $j = $i - 1;
                                        while ($j >= 0 && $data1[$j]['persen'] < $key['persen']) {
                                            $data1[$j + 1] = $data1[$j];
                                            $j--;
                                        }
                                        $data1[$j + 1] = $key;
                                    }
                                }
                            }
                        
                            ?>
                        
                            <?php if (count($data1) > 0): ?>
                                <canvas id="pieChart<?php echo $id_kategori; ?>"></canvas>
                            <?php else: ?>
                                <p>No data available.</p>
                            <?php endif; ?>
                        
                            <!-- menambahkan style -->
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                var ctx = document.getElementById('pieChart<?php echo $id_kategori; ?>').getContext('2d');

                                var labels = <?php echo json_encode(array_column($data1, 'nm_sub_kategori')); ?>;
                                var dataValues = <?php echo json_encode(array_column($data1, 'persen')); ?>;

                                // Fungsi untuk menghasilkan warna pastel secara otomatis
                                function generatePastelColors(count) {
                                    let colors = [];
                                    for (let i = 0; i < count; i++) {
                                        let hue = Math.floor(Math.random() * (150 - 90 + 1)) + 90; // Hijau: 90-150
                                        let saturation = Math.floor(Math.random() * (90 - 70 + 1)) + 70; // Saturasi 70%-90%
                                        let lightness = Math.floor(Math.random() * (60 - 40 + 1)) + 40; // Lightness 40%-60%
                                        
                                        colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
                                    }
                                    return colors;
                                }

                                var data = {
                                    labels: labels,
                                    datasets: [{
                                        data: dataValues,
                                        backgroundColor: generatePastelColors(labels.length), // Warna otomatis sesuai jumlah data
                                        borderWidth: 1
                                    }]
                                };

                                var options = {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom'
                                        },
                                        datalabels: { // Plugin untuk menampilkan jumlah
                                            color: '#000', // Warna teks
                                            font: {
                                                size: 14
                                            },
                                            formatter: (value, context) => {
                                                return value.toFixed(2) + "%"; // Menampilkan angka jumlah
                                            }
                                        }
                                    }
                                };

                                new Chart(ctx, {
                                    type: 'pie',
                                    data: data,
                                    options: options,
                                    plugins: [ChartDataLabels] // Aktifkan plugin
                                });
                            });

                            </script>

                        

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        }}
        ?>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Modal Notification -->
        <?php if(isset($_GET['login']) && $_GET['login'] == 'success'): ?>
                <div class="modal fade" id="loginSuccessModal" tabindex="-1" aria-labelledby="loginSuccessModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="loginSuccessModalLabel">Login Berhasil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Selamat datang! <?php echo $_SESSION['NAMA']; ?> Anda telah berhasil login.
                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var loginSuccessModal = new bootstrap.Modal(document.getElementById('loginSuccessModal'));
                        loginSuccessModal.show();
                    });
                </script>
                <?php endif; ?>
            </div>
    </section>
  </main><!-- End #main -->

  <?php include ('footer.php');?>
      <?php include ('script.php');?>
      
</body>

</html>
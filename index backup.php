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
                            <hr>
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
                                            <th scope="col">Persen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    require 'dbcon.php';
                                    $no = 1;

                                    // Array untuk menyimpan data dari database
                                    $data = [];

                                    // Query untuk mengambil data
                                    $query = $conn->query("SELECT kategori.*, sub_kategori.*, 
                                                            SUM(detail_anggaran.total) AS jml_total
                                                            FROM kategori 
                                                            JOIN sub_kategori ON sub_kategori.id_kategori = kategori.id_kategori
                                                            JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                                            JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                                                            GROUP BY kategori.id_kategori");

                                    // Simpan data hasil query ke array
                                    while ($row = $query->fetch_array()) {
                                        $hasil = $row['jml_total'] / $row['target']*100;
                                        $data[] = [
                                            'jns_kategori' => $row['jns_kategori'],
                                            'nm_kategori' => $row['nm_kategori'],
                                            'target' => $row['target'],
                                            'jml_total' => $row['jml_total'],
                                            'persen' => $hasil
                                        ];
                                    }

                                    // Insertion Sort Berdasarkan 'persen'
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
                                                <td>" . number_format($row['persen'], 2, ",", ".") . "%</td>
                                            </tr>";
                                            $no++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->
                             <hr>
                             <div class="row">
                                <div class="col-12">
                                    <h2 class="mt-3 mb-2 text-center"><b>Progress Anggaran Per Kategori</b></h2>
                                    <?php
                                    foreach ($data as $row) {
                                        echo "
                                        <div class='mb-3'>
                                            <h5>{$row['nm_kategori']}</h5>
                                            <div class='progress'>
                                                <div class='progress-bar bg-primary' role='progressbar' style='width: " . $row['persen'] . "%;' aria-valuenow='" . $row['persen'] . "' aria-valuemin='0' aria-valuemax='100'>
                                                    " . number_format($row['persen'], 2, ",", ".") . "%
                                                </div>
                                            </div>
                                        </div>";
                                    }
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
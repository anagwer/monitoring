<?php include ('session.php');?>
<?php include ('head.php');?>


<body>
<?php 
  require 'dbcon.php';
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  $query2 = $conn->query("SELECT sub_kategori.*, SUM(detail_anggaran.total) AS jml_total, anggaran.id_anggaran
                                FROM sub_kategori
                                JOIN kategori ON kategori.id_kategori = sub_kategori.id_kategori
                                JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                                WHERE detail_anggaran.tgl_pesan between '$tgl1' and '$tgl2'
                                GROUP BY sub_kategori.id_sub_kategori");
  $row2 = $query2->fetch_array();
  ?>
<!-- Table with stripped rows -->
  <div class="row">
    <div class="col-12">
      <h2 class="text-center mb-2" style="font-weight:bold;">Laporan Data Anggaran<br>
        RS Merah Putih<br></h2><p class="text-center" style="font-weight:bold;"> Periode
        <?php if($tgl1==$tgl2){
          echo $tgl1;
          $query = $conn->query("SELECT kategori.*, sub_kategori.*, 
                                SUM(anggaran.anggaran) AS jml_anggaran 
                                FROM kategori 
                                JOIN sub_kategori ON sub_kategori.id_kategori = kategori.id_kategori
                                JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                where kategori.waktu like '%$tgl1%'
                                GROUP BY kategori.id_kategori");
        }else{
          echo $tgl1.' s.d '.$tgl2;
          $tgl2 = date('Y-m-d', strtotime('+1 days', strtotime($tgl2)));
          $query = $conn->query("SELECT kategori.*, sub_kategori.*, 
                                SUM(anggaran.anggaran) AS jml_anggaran 
                                FROM kategori 
                                JOIN sub_kategori ON sub_kategori.id_kategori = kategori.id_kategori
                                JOIN anggaran ON anggaran.id_sub_kategori = sub_kategori.id_sub_kategori
                                where kategori.waktu between '$tgl1' AND '$tgl2'
                                GROUP BY kategori.id_kategori");
        }?></p>
    </div>
  </div>
<hr>
    <table class="table table-bordered">
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
                $hasil = $row['jml_total'] / $row['target'];
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

<div class="row" style="margin-top:100px;">
  <div class="col-8">
  </div>
  <div class="col-4">
    <p class="text-center">Pejabat Pembuat Komitmen<br><br><br><br>
    <u>dr. Leni Puspitowati M.M</u><br>
    NIP. 197501222006042016</p>
  </div>
</div>

      <?php include ('script.php');?>

</body>

</html>
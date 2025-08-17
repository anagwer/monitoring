<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <!-- Navigation -->
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12"><a href="anggaran.php" class="btn btn-danger"><i class="bi bi-arrow-left-short"></i>Back</a><hr>                         
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Detail Anggaran</h5>
                            <?php
                            require 'dbcon.php';
                            $id_anggaran = $_GET['id_anggaran'];
                            $query = $conn->query("SELECT COUNT(*) as jml FROM pengguna");
                            $row = $query->fetch_array();?>   
                            <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="bi bi-plus-lg"></i> Tambah</button>
                            <?php include('add_detail_anggaran_modal.php'); 
                            endif;?>
                            <hr>
                            <!-- Table with stripped rows -->
                             <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Penanggung Jawab</th>
                                        <th scope="col">User ACC</th> <!-- Tambahan kolom -->
                                        <th scope="col">Rekanan</th>
                                        <th scope="col">Uraian</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Tangggal Pesan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Waktu Update</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    require 'dbcon.php';
                                    $no = 1;
                                    $query = $conn->query("SELECT detail_anggaran.*, 
                                                                pengguna.nama AS nama_penanggung_jawab, 
                                                                pengguna_acc.nama AS nama_user_acc
                                                            FROM detail_anggaran 
                                                            JOIN pengguna ON detail_anggaran.id_pengguna = pengguna.id_pengguna
                                                            LEFT JOIN pengguna AS pengguna_acc ON detail_anggaran.id_user_acc = pengguna_acc.id_pengguna
                                                            WHERE detail_anggaran.id_anggaran='$id_anggaran'");
                                    while ($row = $query->fetch_array()) {
                                        // ...
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $no++; ?></th>
                                    <td><?php echo $row['nama_penanggung_jawab']; ?></td>
                                    <td><?php echo $row['nama_user_acc'] ? $row['nama_user_acc'] : '-'; ?></td> <!-- Kolom user ACC -->
                                    <td><?php echo $row['rekanan']; ?></td>
                                    <td><?php echo $row['uraian']; ?></td>
                                    <td><?php echo 'Rp. '.number_format($row['total'], 0, ",", ".");?></td>
                                    <td><?php echo $row['tgl_pesan']; ?></td>
                                    <td>
                                        <?php 
                                            $status = $row['status'];
                                            $class = '';
                                            switch($status) {
                                                case 'Acc':
                                                    $class = 'badge bg-success';
                                                    break;
                                                case 'Wait':
                                                    $class = 'badge bg-warning text-dark';
                                                    break;
                                                case 'Decline':
                                                    $class = 'badge bg-danger';
                                                    break;
                                                default:
                                                    $class = 'badge bg-secondary';
                                            }
                                        ?>
                                        <span class="<?php echo $class; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $row['keterangan']; ?></td>
                                    <td><?php echo $row['tgl_update']; ?></td>
                                    <?php
                                        // ambil role session dan user id session
                                        $role = $_SESSION['ROLE'];
                                        $user_id = $_SESSION['ID']; // Asumsi kamu punya session simpan id user di sini

                                        $id_user_acc = $row['id_user_acc']; // user yang ACC PBJ

                                        // cek status Acc (misal ini status akhir, kamu bisa modifikasi sesuai kebutuhan)
                                        $status = $row['status'];

                                        // Logika tombol edit
                                        $show_edit = false;

                                        if ($role == 'PBJ') {
                                            // PBJ hanya bisa edit jika id_user_acc sama dengan dirinya sendiri (belum di-ACC orang lain)
                                            if ($id_user_acc == $user_id || $id_user_acc == null || $id_user_acc == '') {
                                                $show_edit = true;
                                            }
                                        } elseif ($role == 'Kasubag') {
                                            // Kasubag hanya bisa edit jika sudah di-ACC PBJ (id_user_acc sudah ada dan bukan Kasubag sendiri), dan status belum Acc
                                            if ($id_user_acc != null && $id_user_acc != '' && $status != 'Acc') {
                                                $show_edit = true;
                                            }
                                        }

                                        // Jika sudah Acc (status == 'Acc') maka tidak ada edit untuk siapapun
                                        if ($status == 'Acc') {
                                            $show_edit = false;
                                        }
                                        ?>

                                        <td style="text-align:center">
                                            <?php if($row['bukti'] == '') { 
                                                echo '-'; 
                                            } else { ?>
                                                <a href="upload/bukti/<?php echo $row['bukti']?>" target="_BLANK" class="btn btn-warning"><i class="bi bi-eye"></i></a>
                                            <?php } ?>

                                            <?php if ($show_edit) { ?>
                                                <a rel="tooltip" title="Edit" id="<?php echo $row['id_detail_anggaran'] ?>" href="#edit_detail_anggaran<?php echo $row['id_detail_anggaran'];?>" data-toggle="modal" class="btn btn-success btn-outline"><i class="bi bi-pencil-square"></i></a>
                                            <?php } ?>

                                            <?php if ($_SESSION['ROLE'] == 'Admin' && $status != 'Acc') { ?>
                                                <a rel="tooltip" title="Delete" id="<?php echo $row['id_detail_anggaran'] ?>" href="#delete_detail_anggaran<?php echo $row['id_detail_anggaran'];?>" data-toggle="modal" class="btn btn-danger btn-outline"><i class="bi bi-trash-fill"></i></a>
                                            <?php } ?>
                                        </td>

                                </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <?php include('footer.php'); ?>
    <?php include('script.php'); ?>
</body>
</html>
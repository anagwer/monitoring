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
                                        $bool = false;
                                        $query = $conn->query("SELECT detail_anggaran.*, pengguna.nama FROM detail_anggaran 
                                                                            join pengguna on detail_anggaran.id_pengguna=pengguna.id_pengguna
                                                                            where detail_anggaran.id_anggaran='$id_anggaran'");
                                        while ($row = $query->fetch_array()) {
                                            $id_detail_anggaran = $row['id_detail_anggaran'];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $no++; ?></th>
                                        <td><?php echo $row['nama']; ?></td>
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
                                                    $class = 'badge bg-success'; // hijau
                                                    break;
                                                case 'Wait':
                                                    $class = 'badge bg-warning text-dark'; // kuning
                                                    break;
                                                case 'Decline':
                                                    $class = 'badge bg-danger'; // merah
                                                    break;
                                                default:
                                                    $class = 'badge bg-secondary'; // default jika ada status lain
                                            }
                                        ?>
                                        <span class="<?php echo $class; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                        </td>
                                        <td><?php echo $row['keterangan']; ?></td>
                                        <td><?php echo $row['tgl_update']; ?></td>
                                        <td style="text-align:center">
                                            <?php if($row['bukti']==''){
                                                echo '-';
                                            }else{?>                                        
                                                <a href="upload/bukti/<?php echo $row['bukti']?>" target="_BLANK" class="btn btn-warning"><i class="bi bi-eye"></i></a>
                                            <?php }
                                            
                                            if($row['status']!='Acc'){?>
                                                <a rel="tooltip" title="Edit" id="<?php echo $row['id_detail_anggaran'] ?>" href="#edit_detail_anggaran<?php echo $row['id_detail_anggaran'];?>" data-toggle="modal" class="btn btn-success btn-outline"><i class="bi bi-pencil-square"></i> </a>
                                                <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                                                <a rel="tooltip" title="Delete" id="<?php echo $row['id_detail_anggaran'] ?>" href="#delete_detail_anggaran<?php echo $row['id_detail_anggaran'];?>" data-toggle="modal" class="btn btn-danger btn-outline"><i class="bi bi-trash-fill"></i> </a>
                                            <?php endif; } ?>
                                        </td>
                                    </tr>
                                    <?php
                                        require 'edit_detail_anggaran_modal.php';
                                        require 'delete_detail_anggaran_modal.php';
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
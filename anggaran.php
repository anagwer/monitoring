<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <!-- Navigation -->
    <?php include('side_bar.php'); ?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Anggaran</h5>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="bi bi-plus-lg"></i> Tambah</button>
                            <?php include('add_anggaran_modal.php'); ?>
                            <hr>
                            <!-- Table with stripped rows -->
                             <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Uraian</th>
                                        <th scope="col">anggaran</th>
                                        <th scope="col">realisasi_keuangan</th>
                                        <th scope="col">waktu</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        require 'dbcon.php';
                                        $no = 1;
                                        $bool = false;
                                        $query = $conn->query("SELECT anggaran.*, sub_kategori.* FROM anggaran JOIN sub_kategori ON anggaran.id_sub_kategori=sub_kategori.id_sub_kategori JOIN kategori ON sub_kategori.id_kategori=kategori.id_kategori");
                                        while ($row = $query->fetch_array()) {
                                            $id_anggaran = $row['id_anggaran'];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $no++; ?></th>
                                        <td><?php echo $row['nm_sub_kategori']; ?></td>
                                        <td><?php echo $row['uraian']; ?></td>
                                        <td><?php $query1 = $conn->query("SELECT SUM(total) as jml FROM detail_anggaran where id_anggaran='$id_anggaran'");
                                                $row1 = $query1->fetch_array(); 
                                                echo 'Rp. '.number_format($row1['jml'], 0, ",", ".");?></td>
                                        <td><?php echo 'Rp. '.number_format($row['realisasi_keuangan'], 0, ",", ".");?></td>
                                        
                                        <td><?php echo $row['waktu']; ?></td>
                                        <td style="text-align:center">
                                            
                                        <a href="detail_anggaran.php?id_anggaran=<?php echo $row['id_anggaran'];?>" class="btn btn-warning btn-outline"><i class="bi bi-eye"></i> </a>
                                            <a rel="tooltip" title="E   dit" id="<?php echo $row['id_anggaran'] ?>" href="#edit_anggaran<?php echo $row['id_anggaran'];?>" data-toggle="modal" class="btn btn-success btn-outline"><i class="bi bi-pencil-square"></i> </a>
                                            <?php if($row1['jml']==0){?>
                                            <a rel="tooltip" title="Delete" id="<?php echo $row['id_anggaran'] ?>" href="#delete_anggaran<?php echo $row['id_anggaran'];?>" data-toggle="modal" class="btn btn-danger btn-outline"><i class="bi bi-trash-fill"></i> </a>    
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php
                                        require 'edit_anggaran_modal.php';
                                        require 'delete_anggaran_modal.php';
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
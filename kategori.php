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
                            <h5 class="card-title">Data Uraian</h5>
                            <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="bi bi-plus-lg"></i> Tambah</button>
                            <?php include('add_kategori_modal.php'); 
                            endif;?>
                            <hr>
                            <!-- Table with stripped rows -->
                             
                            <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Jenis Uraian</th>
                                        <th scope="col">Nama Uraian</th>
                                        <th scope="col">Pagu Anggaran</th>
                                        <th scope="col">Penanggung Jawab</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Updated At</th>
                                        <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                                        <th scope="col">Aksi</th>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        require 'dbcon.php';
                                        $no = 1;
                                        $bool = false;
                                        $query = $conn->query("SELECT kategori.*, pengguna.nama 
                                                            FROM kategori 
                                                            LEFT JOIN pengguna ON kategori.id_user = pengguna.id_pengguna 
                                                            ORDER BY kategori.id_kategori DESC");
                                        while ($row = $query->fetch_array()) {
                                            $id_kategori = $row['id_kategori'];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $no++; ?></th>
                                        <td><?php echo $row['jns_kategori']; ?></td>
                                        <td><?php echo $row['nm_kategori']; ?></td>
                                        <td><?php echo 'Rp. '.number_format($row['target'], 0, ",", ".");?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><?php echo $row['updated_at']; ?></td>
                                        <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                                        <td style="text-align:center">
                                            <a rel="tooltip" title="Edit" id="<?php echo $row['id_kategori'] ?>" href="#edit_kategori<?php echo $row['id_kategori'];?>" data-toggle="modal" class="btn btn-success btn-outline"><i class="bi bi-pencil-square"></i> </a>
                                            <a rel="tooltip" title="Delete" id="<?php echo $row['id_kategori'] ?>" href="#delete_kategori<?php echo $row['id_kategori'];?>" data-toggle="modal" class="btn btn-danger btn-outline"><i class="bi bi-trash-fill"></i> </a>
                                        </td>
                                        <?php endif;?>
                                    </tr>
                                    <?php
                                        require 'edit_kategori_modal.php';
                                        require 'delete_kategori_modal.php';
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
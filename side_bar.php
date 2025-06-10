<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">SIMONANG</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="profil.php">
                <i class="bi bi-person-circle" class="rounded-circle" style="margin-right:10px;font-size:30px;"></i>
                    <?php echo $_SESSION['NAMA'];?>
                </a><!-- End Profile Image Icon -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
<?php 
    // Get current page name
    $current_page = basename($_SERVER['PHP_SELF']); 
?>
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- mulai sidebar biasa -->
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'index.php' ? '' : 'collapsed'; ?>" href="index.php">
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'kategori.php' ? '' : 'collapsed'; ?>" href="kategori.php">
                <span>Data Kategori</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'sub_kategori.php' ? '' : 'collapsed'; ?>" href="sub_kategori.php">
                <span>Data Sub Kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'anggaran.php' ? '' : 'collapsed'; ?>" href="anggaran.php">
                <span>Data Anggaran</span>
            </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link <?php echo $current_page == 'logout.php' ? '' : 'collapsed'; ?>" data-toggle="modal" data-target="#myModal1"> Logout</a>
        </li><!-- End Data User Nav -->
    </ul>
    
</aside><!-- End Sidebar -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="logout.php" enctype="multipart/form-data">    
                    Apakah anda yakin akan keluar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button name="save" type="submit" class="btn btn-primary">Ya</button>
                </form>  
            </div>
        </div>
    </div>
</div>
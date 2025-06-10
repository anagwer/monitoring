<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">    
                    <div class="form-group">
                        <label class="form-label">Sub Kategori</label>
                        <select name="id_sub_kategori" id="id_sub_kategori" class="form-select" required>
							<option selected disabled value>-- Pilih Sub kategori --</option>
							<?php    
							$result = mysqli_query($con, "SELECT sub_kategori.*, kategori.* FROM sub_kategori JOIN kategori ON sub_kategori.id_kategori=kategori.id_kategori");  
							while ($row = mysqli_fetch_array($result)) { 
							?>
								<option value="<?php echo $row['id_sub_kategori']; ?>">
                                <?php echo $row['nm_kategori'].' | '. $row['nm_sub_kategori']; ?>
								</option>
							<?php } ?>
						</select>             
                    </div>
                    <div class="form-group">
                        <label class="form-label">Uraian</label>
                        <input type="text" class="form-control" name="uraian" required>                        
                    </div>
                    <div class="form-group">
                        <label class="form-label">Realisasi Keuangan</label>
                        <input type="text" class="form-control" name="realisasi_keuangan">                        
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button name="save" type="submit" class="btn btn-primary">Simpan</button>
                </form>  
            </div>
        </div>
    </div>
</div>

<?php 
require_once 'dbcon.php';

if (isset($_POST['save'])) {

    $id_sub_kategori = $_POST['id_sub_kategori'];
    $uraian = $_POST['uraian'];
    $realisasi_keuangan = $_POST['realisasi_keuangan'];
    
    $conn->query("INSERT INTO anggaran VALUES (NULL, '$id_sub_kategori', '$uraian', '$realisasi_keuangan', CURRENT_TIMESTAMP());");
    echo "<script>window.location.href='anggaran.php';</script>";


    }
?>

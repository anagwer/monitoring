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
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-select" onchange="changeValue2(this.value)" required>
							<option selected disabled value>-- Pilih kategori --</option>
							<?php    
							$result = mysqli_query($con, "SELECT * FROM kategori");  
							while ($row = mysqli_fetch_array($result)) { 
							?>
								<option value="<?php echo $row['id_kategori']; ?>">
									<?php echo $row['nm_kategori']; ?>
								</option>
							<?php } ?>
						</select>             
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Sub Kategori</label>
                        <input type="text" class="form-control" name="nm_sub_kategori" required>                        
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

    $id_kategori = $_POST['id_kategori'];
    $nm_sub_kategori = $_POST['nm_sub_kategori'];
    
    $conn->query("INSERT INTO sub_kategori VALUES (NULL, '$id_kategori', '$nm_sub_kategori', CURRENT_TIMESTAMP());");
    echo "<script>window.location.href='sub_kategori.php';</script>";


    }
?>

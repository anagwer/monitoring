
<?php
	if(!$bool){
?>

<div class="modal fade" id="edit_sub_kategori<?php echo $id_sub_kategori; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="id_sub_kategori" value="<?php echo $row['id_sub_kategori'] ?>">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="id_kategori">
                            <option value="<?php echo $row['id_kategori'];?>"><?php echo $row['nm_kategori'];?></option>                   
                            <?php    
							$result = mysqli_query($con, "SELECT * FROM kategori");  
							while ($row1 = mysqli_fetch_array($result)) { 
							?>
								<option value="<?php echo $row1['id_kategori']; ?>">
									<?php echo $row1['nm_kategori']; ?>
								</option>
							<?php } ?>
                        </select>                
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Sub Kategori</label>
                        <input type="text" class="form-control" value="<?php echo $row['nm_sub_kategori'];?>" name="nm_sub_kategori" required>                        
                    </div>
                    <br>
                    <button name="update" type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php 

    if (isset($_POST['update'])) {
        $id_sub_kategori = $_POST['id_sub_kategori'];
        $id_kategori = $_POST['id_kategori'];
        $nm_sub_kategori = $_POST['nm_sub_kategori'];
        $conn->query("UPDATE sub_kategori SET id_kategori = '$id_kategori', nm_sub_kategori = '$nm_sub_kategori' WHERE id_sub_kategori = '$id_sub_kategori'") or die(mysqli_error($conn));
        echo "<script>window.location='sub_kategori.php'</script>";
    }
?>
								
<?php
	}
?>
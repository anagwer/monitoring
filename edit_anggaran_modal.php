
<?php
	if(!$bool){
?>

<div class="modal fade" id="edit_anggaran<?php echo $id_anggaran; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="id_anggaran" value="<?php echo $row['id_anggaran'] ?>">
                    <div class="form-group">
                        <label class="form-label">Sub Kategori</label>
                        <select name="id_sub_kategori" id="id_sub_kategori" class="form-select" required>
							<option value="<?php echo $row['id_sub_kategori'];?>"><?php echo $row['nm_sub_kategori'];?></option>
							<?php    
							$result1 = mysqli_query($con, "SELECT sub_kategori.*, kategori.* FROM sub_kategori JOIN kategori ON sub_kategori.id_kategori=kategori.id_kategori");  
							while ($row1 = mysqli_fetch_array($result1)) { 
							?>
								<option value="<?php echo $row1['id_sub_kategori']; ?>">
                                <?php echo $row1['nm_kategori'].' | '. $row1['nm_sub_kategori']; ?>
								</option>
							<?php } ?>
						</select>             
                    </div>
                    <div class="form-group">
                        <label class="form-label">Uraian</label>
                        <input type="text" class="form-control" name="uraian" value="<?php echo $row['uraian'];?>" required>                        
                    </div>
                    <div class="form-group">
                        <label class="form-label">Realisasi Keuangan</label>
                        <input type="text" class="form-control" name="realisasi_keuangan" value="<?php echo $row['realisasi_keuangan'];?>" >                        
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
        $id_anggaran = $_POST['id_anggaran'];
        $id_sub_kategori = $_POST['id_sub_kategori'];
        $uraian = $_POST['uraian'];
        $realisasi_keuangan = $_POST['realisasi_keuangan'];
        $conn->query("UPDATE anggaran SET id_sub_kategori = '$id_sub_kategori', uraian = '$uraian', realisasi_keuangan = '$realisasi_keuangan' WHERE id_anggaran = '$id_anggaran'") or die(mysqli_error($conn));
        echo "<script>window.location='anggaran.php'</script>";
    }
?>
								
<?php
	}
?>
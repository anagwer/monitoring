<?php
	if(!$bool){
?>

<div class="modal fade" id="edit_kategori<?php echo $id_kategori; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="id_kategori" value="<?php echo $row['id_kategori'] ?>">
                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['ID']; ?>">

                    <div class="form-group">
                        <label class="form-label">Jenis Kategori</label>
                        <select class="form-select" name="jns_kategori">
                            <option><?php echo $row['jns_kategori'];?></option>                   
                            <option>OPERASI</option>                   
                            <option>MODAL</option>   
                        </select>                
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" value="<?php echo $row['nm_kategori'];?>" name="nm_kategori" required>                        
                    </div>
                    <div class="form-group">
                        <label class="form-label">Target</label>
                        <input type="number" class="form-control" name="target" value="<?php echo $row['target'];?>" required>                        
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
        $id_kategori = $_POST['id_kategori'];
        $jns_kategori = $_POST['jns_kategori'];
        $nm_kategori = $_POST['nm_kategori'];
        $target = $_POST['target'];
        $id_user = $_POST['id_user'];

        $conn->query("UPDATE kategori 
                      SET jns_kategori = '$jns_kategori', 
                          nm_kategori = '$nm_kategori', 
                          target = '$target', 
                          id_user = '$id_user', 
                          updated_at = CURRENT_TIMESTAMP() 
                      WHERE id_kategori = '$id_kategori'") 
            or die(mysqli_error($conn));

        echo "<script>window.location='kategori.php'</script>";
    }
?>

<?php
	}
?>

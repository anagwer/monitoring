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
                        <label class="form-label">Jenis Kategori</label>
                        <select class="form-select" name="jns_kategori">
                            <option>OPERASI</option>                   
                            <option>MODAL</option>   
                        </select>                
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nm_kategori" required>                        
                    </div>
                    <div class="form-group">
                        <label class="form-label">Target</label>
                        <input type="number" class="form-control" name="target" required>                        
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

    $jns_kategori = $_POST['jns_kategori'];
    $nm_kategori = $_POST['nm_kategori'];
    $target = $_POST['target'];
    
    $conn->query("INSERT INTO kategori VALUES (NULL, '$jns_kategori', '$nm_kategori', '$target', CURRENT_TIMESTAMP());");
    echo "<script>window.location.href='kategori.php';</script>";


    }
?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">   
                    <div class="form-group">
                        <label class="form-label">Rekanan</label>
                        <input type="text" class="form-control" name="rekanan" required>                        
                        <input type="hidden" class="form-control" name="id_anggaran" value="<?php echo $id_anggaran;?>" required>                        
                        <input type="hidden" class="form-control" name="id_pengguna" value="<?php echo $_SESSION['ID'];?>" required>                        
                    </div> 
                    <div class="form-group">
                        <label class="form-label">Uraian</label>
                        <!-- TinyMCE Editor -->
                        <textarea class="tinymce-editor" name="uraian" placeholder="Masukkan detail uraian pembelanjaan....">
                        </textarea><!-- End TinyMCE Editor -->
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total</label>
                        <input type="number" class="form-control" name="total" required>                        
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bukti</label>
                        <input type="file" class="form-control" name="bukti">                        
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pesan</label>
                        <input type="date" class="form-control" name="tgl_pesan" required>                        
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

    $id_anggaran = $_POST['id_anggaran'];
    $rekanan = $_POST['rekanan'];
    $uraian = $_POST['uraian'];
    $id_pengguna = $_POST['id_pengguna'];

    $total = $_POST['total'];
    $tgl_pesan = $_POST['tgl_pesan'];
    // Fungsi untuk memeriksa apakah file PDF
    function isPDF($filename) {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'pdf';
    }
    $file_name = $_FILES['bukti']['name'];
	$file_tmp = $_FILES['bukti']['tmp_name'];
    if (isPDF($file_name)) {
        // Pindahkan file ke folder tujuan
        move_uploaded_file($file_tmp, "upload/bukti/" . $file_name);
        $conn->query("INSERT INTO detail_anggaran VALUES (NULL, '$id_pengguna','$id_anggaran', '$rekanan', '$uraian', '$total', '$file_name', '$tgl_pesan', CURRENT_TIMESTAMP(), '','Wait');");
        echo "<script>window.location.href='detail_anggaran.php?id_anggaran=" . $id_anggaran . "';</script>";
        } else {
            echo "<script>alert('Gagal mengupload file. File harus berupa PDF.');</script>";
            exit;
        }
    }
?>

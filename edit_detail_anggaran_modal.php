<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
	if(!$bool){
?>

<div class="modal fade" id="edit_detail_anggaran<?php echo $id_detail_anggaran; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id_detail_anggaran" value="<?php echo $row['id_detail_anggaran'] ?>">                 
                    <input type="hidden" class="form-control" name="id_anggaran" value="<?php echo $id_anggaran;?>" required>                        
                    <input type="hidden" class="form-control" name="id_pengguna" value="<?php echo $_SESSION['ID'];?>" required>   
                    <?php if ($_SESSION['ROLE'] == 'Admin'): ?>
                        <div class="form-group">
                            <label class="form-label">Rekanan</label>
                            <input type="text" class="form-control" name="rekanan"  value="<?php echo $row['rekanan'];?>" required>                            
                        </div> 
                        <div class="form-group">
                            <label class="form-label">Uraian</label>
                            <!-- TinyMCE Editor -->
                            <textarea class="tinymce-editor" name="uraian" placeholder="Masukkan detail uraian pembelanjaan...."><?php echo $row['uraian'];?>
                            </textarea><!-- End TinyMCE Editor -->
                        </div>

                        <div class="form-group">
                            <label class="form-label">Total</label>
                            <input type="number" class="form-control" name="total" value="<?php echo $row['total'];?>"B required>                        
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bukti</label>
                            <input type="file" class="form-control" name="bukti" >                        
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Pesanan</label>
                            <input type="date" class="form-control" name="tgl_pesan" value="<?php echo $row['tgl_pesan'];?>" required>                        
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Acc" <?= ($row['status'] == 'Acc') ? 'selected' : '' ?>>Acc</option>
                                <option value="Wait" <?= ($row['status'] == 'Wait') ? 'selected' : '' ?>>Wait</option>
                                <option value="Decline" <?= ($row['status'] == 'Decline') ? 'selected' : '' ?>>Decline</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Isi keterangan jika diperlukan"><?php  echo $row['keterangan']; ?></textarea>
                        </div>
                    <?php endif; ?>
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
        $id_detail_anggaran = $_POST['id_detail_anggaran'];
        $id_anggaran = $_POST['id_anggaran'];
        $id_pengguna = $_POST['id_pengguna'];

        // Hanya proses upload file jika pengguna adalah Admin
        if ($_SESSION['ROLE'] == 'Admin') {
                
            $rekanan = $_POST['rekanan'];
            $uraian = $_POST['uraian'];
            $total = $_POST['total'];
            $tgl_pesan = $_POST['tgl_pesan'];
            
            $file_name = isset($_FILES['bukti']) && !empty($_FILES['bukti']['name']) ? $_FILES['bukti']['name'] : '';
            $file_tmp = isset($_FILES['bukti']) && !empty($_FILES['bukti']['tmp_name']) ? $_FILES['bukti']['tmp_name'] : '';

            // Fungsi untuk memeriksa file PDF
            function isPDF($filename) {
                return strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'pdf';
            }

            if (!empty($file_name)) {
                $upload_dir = "upload/bukti/";

                if (isPDF($file_name)) {
                    if (file_exists($upload_dir . $file_name)) {
                        // File sudah ada, tampilkan alert
                        echo "<script>alert('Gagal mengupload file. File dengan nama yang sama sudah ada.');</script>";
                    } else {
                        // File belum ada, lanjutkan proses upload
                        move_uploaded_file($file_tmp, $upload_dir . $file_name);
                        $conn->query("UPDATE detail_anggaran SET 
                            rekanan = '$rekanan',
                            id_pengguna = '$id_pengguna',
                            uraian = '$uraian',
                            total = '$total',
                            tgl_pesan = '$tgl_pesan',
                            bukti = '$file_name' 
                            WHERE id_detail_anggaran = '$id_detail_anggaran'") or die(mysqli_error($conn));
                        echo "<script>alert('File berhasil diupload'); window.location.href='detail_anggaran.php?id_anggaran=$id_anggaran';</script>";
                    }
                } else {
                    echo "<script>alert('Gagal mengupload file. File harus berupa PDF.');</script>";
                }
            } else {
                // Update tanpa file
                $conn->query("UPDATE detail_anggaran SET 
                    rekanan = '$rekanan',
                    id_pengguna = '$id_pengguna',
                    uraian = '$uraian',
                    total = '$total',
                    tgl_pesan = '$tgl_pesan' 
                    WHERE id_detail_anggaran = '$id_detail_anggaran'") or die(mysqli_error($conn));
                echo "<script>window.location.href='detail_anggaran.php?id_anggaran=$id_anggaran';</script>";
            }
        } else {
            $status = $_POST['status'];
            $keterangan = $_POST['keterangan'];
            // Untuk pengguna non-Admin, update tanpa file
            $conn->query("UPDATE detail_anggaran SET 
                status = '$status',
                keterangan = '$keterangan'
                WHERE id_detail_anggaran = '$id_detail_anggaran'") or die(mysqli_error($conn));
            echo "<script>window.location.href='detail_anggaran.php?id_anggaran=$id_anggaran';</script>";
        }
    }
}
?>
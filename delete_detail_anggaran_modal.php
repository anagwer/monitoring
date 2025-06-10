<?php
	if(!$bool){
?>
<div class="modal fade" id="delete_detail_anggaran<?php echo $id_detail_anggaran?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
				<h5 class="modal-title">Hapus</h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div>
																
			<div class="modal-body">
				Apa Kamu yakin akan menghapus detail_anggaran?
			</div>
									
			<div class="modal-footer">
				<form method = "post" enctype = "multipart/form-data">	
				<input type="hidden" name="id_detail_anggaran" value="<?php echo $row['id_detail_anggaran'] ?>">
				<button name = "delete" type="submit" class="btn btn-danger">Yes</button>
				</form>
				<button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
			</div>
		</div>
			
<!-- /.modal-content -->

	</div>
		
<!-- /.modal-dialog -->
	
</div>
<?php
	require_once 'dbcon.php';
	if(ISSET($_POST['delete'])){
		$id_detail_anggaran=$_POST['id_detail_anggaran'];
		$conn->query("delete from detail_anggaran where id_detail_anggaran='$id_detail_anggaran'") or die(mysql_error());
		echo "<script> window.location='detail_anggaran.php?id_anggaran=$id_anggaran' </script>";
	}
}
?>
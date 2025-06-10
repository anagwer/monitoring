<?php
	if(!$bool){
?>

<div class="modal fade" id="lihat<?php echo $id_sub_kategori; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                $data1 = [];
                $result1 = mysqli_query($con, "SELECT sub_kategori.*, detail_anggaranSUM(detail_anggaran.total) AS jml_total FROM 
                                                    sub_kategori JOIN anggaran ON anggaran.id_sub_kategori=sub_kategori.id_sub_kategori
                                                    JOIN detail_anggaran ON anggaran.id_anggaran = detail_anggaran.id_anggaran
                                                    where sub_kategori.id_sub_kategori='$id_sub_kategori'");  
                ?>
                <h5 class="modal-title">Monitoring </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php // Simpan data1 hasil query ke array
                    while ($row1 = $result1->fetch_array()) {
                        $hasil = $row1['jml_total'] / $row1['target']*100;
                        $data1[] = [
                            'jns_kategori' => $row1['jns_kategori'],
                            'nm_kategori' => $row1['nm_kategori'],
                            'target' => $row1['target'],
                            'jml_total' => $row1['jml_total'],
                            'persen' => $hasil
                        ];
                    }
                    // Insertion Sort Berdasarkan 'persen'
                    for ($i = 1; $i < count($data1); $i++) {
                        $key1 = $data1[$i];
                        $h = $i - 1;
                        while ($h >= 0 && $data1[$h]['persen'] > $key1['persen']) {
                            $data1[$h + 1] = $data1[$h];
                            $h--;
                        }
                        $data1[$h + 1] = $key1;
                    }

                    foreach ($data1 as $row1) {?>
                        <div class='mb-3'>
                            <h5><?php echo $row1['nm_sub_kategori']?></h5>
                            <div class='progress'>
                                <div class='progress-bar bg-primary' role='progressbar' style="width: <?php echo $row1['persen'] . '%';?>" aria-valuenow= "<?php echo $row1['persen'];?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo number_format($row1['persen'], 2, ",", ".") . "%";?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
								
<?php
	}
?>
<div class="modal-header">
	<h5 class="modal-title" id="klienLabel"><?=$judul;?><?=$akuntan['nama_akuntan'];?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
    <table class="table table-sm table-striped">
        <thead class="text-center">
            <tr>
                <th>ID Klien</th>
                <th>Nama Klien</th>
            </tr>
        </thead>
        
        <tbody class="text-center">
            <?php
                $id = explode(",",$akuntan['id_klien']);
                
				foreach($klien as $k) :
				    foreach($id as $i => $value) :
						if($value == $k['id_klien']) {
            ?>
            <tr>
                <td><?= $k['id_klien']; ?></td>
                <td><?= $k['nama_klien']; ?></td>
            </tr>
            <?php
						}
					endforeach;
				endforeach; 
			?>
        </tbody>
    </table>
</div>
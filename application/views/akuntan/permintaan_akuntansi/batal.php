<div class="modal-header">
	<h5 class="modal-title" id="detailAkunLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container-fluid p-0">
		<table class="table table-borderless" style="width:fit-content">
			<tbody>
				<tr>
					<td>Jenis Data</td>
					<td> : <?=$detail['jenis_data']?></td>
				</tr>
				<tr>
					<td>Detail</td>
					<td> : <?=$detail['detail']?></td>
				</tr>
				<tr>
					<td>Format Data</td>
					<td> : <?=$detail['format_data']?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td> : <?= $detail['ket_status'] ?></td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-sm table-bordered">
			<thead class="text-center">
				<tr>
					<th>Pengiriman ke</th>
					<th>Tanggal pengiriman</th>
					<th><?= $detail['format_data'] == 'Softcopy' ? 'File' : 'Tanggal Ambil' ?></th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php 
					if($pengiriman) :
						foreach($pengiriman as $p) : ?>
				<tr>
					<td><?=$p['pengiriman']?></td>
					<td><?=$p['tanggal_pengiriman']?></td>
					<td><?=$p['file']?></td>
					<td class="text-left"><?=$p['ket_pengiriman']?></td>
				</tr>
					<?php endforeach; else : ?>
				<tr>
					<td colspan="5">Belum ada pengiriman</td>
				</tr>
				<?php endif ?>
			</tbody>
		</table>
	</div>
</div>
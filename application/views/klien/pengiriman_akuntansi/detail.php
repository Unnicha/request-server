<div class="modal-header">
	<h5 class="modal-title" id="detailAkunLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container-fluid p-0">
		<table class="table table-striped table-bordered table-detail" id="data">
			<tbody>
				<tr>
					<td colspan="2">Tanggal Permintaan</td>
					<td><?= $pengiriman['tanggal_permintaan']; ?></td>
				</tr>
				<tr>
					<td colspan="2">Permintaan ke</td>
					<td><?= $pengiriman['request'] ?></td>
				</tr>
				<tr>
					<td colspan="2">Pengiriman ke</td>
					<td><?= $pengiriman['pengiriman'] ?></td>
				</tr>
			</tbody>
		</table>
		
		<div class="row py-2">
			<div class="col"><h5 class="my-1">Detail Data (<?= count($isi) ?>)</h5></div>
		</div>
		
		<table class="table table-striped table-bordered mb-0">
			<tbody>
			<?php foreach($isi as $i => $val) : ?>
				<!-- Data <?=$i+1?> -->
				<tr>
					<td class="text-center"><?=$i+1?>.</td>
					<td>Jenis Data</td>
					<td><?= $val['jenis_data'] ?></td>
				</tr>
				<tr>
					<td></td>
					<td>Detail</td>
					<td><?= $val['detail'] ?></td>
				</tr>
				<?php if($val['tanggal_pengiriman']) : ?>
				<tr>
					<td></td>
					<td>Tanggal Pengiriman</td>
					<td><?= $val['tanggal_pengiriman'] ?></td>
				</tr>
				<tr>
					<td></td>
					<td><?= $add[$i]['file_title'] ?></td>
					<td><?= $add[$i]['file'] ?></td>
				</tr>
				<tr>
					<td></td>
					<td>Note</td>
					<td><?= $val['ket_file'] ? $val['ket_file'] : '<br>' ?></td>
				</tr>
				<?php else : ?>
				<tr>
					<td></td>
					<td>Format Data</td>
					<td><?= $val['format_data'] ?></td>
				</tr>
				<?php endif ?>
				<tr>
					<td></td>
					<td>Status</td>
					<td><?= $add[$i]['status'] ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$('[data-toggle="tooltip"]').mouseover(function() {
		$(this).tooltip();
	});
</script>
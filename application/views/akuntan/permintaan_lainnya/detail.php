<div class="modal-header px-4">
	<h4 class="modal-title"><?= $judul ?></h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-3">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col">
				<table class="table table-detail mb-4">
					<tbody>
						<tr>
							<td scope="row">Nama Klien</td>
							<td><?=$permintaan['nama_klien']?></td>
						</tr>
						<tr>
							<td scope="row" width="40%">Permintaan ke</td>
							<td><?=$permintaan['request']?></td>
						</tr>
						<tr>
							<td scope="row">Tanggal permintaan</td>
							<td><?=$permintaan['tanggal_permintaan']?></td>
						</tr>
						<tr>
							<td scope="row">Jumlah data</td>
							<td><?= $permintaan['jumData'] ?></td>
						</tr>
						<tr>
							<td scope="row">Requestor</td>
							<td><?= $permintaan['nama'] ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="row mb-2">
			<div class="col">
				<p class="lead mb-0">
					<b class="px-2">Detail Data</b>
					<a href="<?=base_url('akuntan/permintaan_data_lainnya/edit/'.$permintaan['id_permintaan'])?>" class="btn-edit" data-toggle="tooltip" data-placement="right" title="Edit Permintaan">
						<i class="bi bi-pencil-square" style="font-size:20px; line-height:80%"></i>
					</a>
				</p>
			</div>
		</div>
		
		<table class="table table-striped">
			<thead class="text-center">
				<tr>
					<th>No.</th>
					<th>Nama Data</th>
					<th>Detail</th>
					<th>Format Data</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php
					foreach($detail as $d => $val) : ?>
				<tr>
					<td><?=$d+1?>.</td>
					<td><?=$val['jenis_data']?></td>
					<td><?=$val['detail']?></td>
					<td><?=$val['format_data']?></td>
					<td><?=$badge[$d]?></td>
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
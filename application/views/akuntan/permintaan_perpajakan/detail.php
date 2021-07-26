<div class="modal-header">
	<h5 class="modal-title" id="detailAkunLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container-fluid p-0">
	<table class="table table-striped table-detail" id="data">
		<tbody>
			<tr>
				<td scope="row">Tanggal Permintaan</td>
				<td><?= $permintaan['tanggal_permintaan']; ?></td>
			</tr>
			<tr>
				<td scope="row">Nama Klien</td>
				<td><?= $permintaan['nama_klien']; ?></td>
			</tr>
			<tr>
				<td scope="row">Bulan / Tahun</td>
				<td><?= $bulan .' / '. $permintaan['tahun']; ?></td>
			</tr>
			<tr>
				<td scope="row">Permintaan ke</td>
				<td><?= $permintaan['request'] ?></td>
			</tr>
			<tr>
				<td scope="row">Requestor</td>
				<td><?= ucwords($permintaan['level']) .' - '. $permintaan['nama'] ?></td>
			</tr>
			<tr>
				<td colspan="2"><h6 class="my-1">Data (<?=count($isi)?>)</h6></td>
			</tr>
			<?php $num=0; foreach($isi as $i) : ?>
			<tr>
				<td colspan="2">
					<div class="form-row">
						<div class="col-1 text-center">
							<?= ++$num ?>.
						</div>
						<div class="col">
							<div class="form-row mb-1">
								<div class="col-5">Jenis Data</div>
								<div class="col">: <?= $i['jenis_data'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col-5">Keterangan</div>
								<div class="col">: <?= $i['detail'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col-5">Format Data</div>
								<div class="col">: <?= $i['format_data'] ?></div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
</div>
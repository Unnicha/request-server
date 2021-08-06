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
				<td><?= $permintaan['tanggal_permintaan']; ?></td>
			</tr>
			<tr>
				<td colspan="2">Nama Klien</td>
				<td><?= $permintaan['nama_klien']; ?></td>
			</tr>
			<tr>
				<td colspan="2">Bulan / Tahun</td>
				<td><?= $bulan .' / '. $permintaan['tahun']; ?></td>
			</tr>
			<tr>
				<td colspan="2">Permintaan ke</td>
				<td><?= $permintaan['request'] ?></td>
			</tr>
			<tr>
				<td colspan="2">Requestor</td>
				<td><?= ucwords($permintaan['level']) .' - '. $permintaan['nama'] ?></td>
			</tr>
			<tr>
				<td colspan="3"><h6 class="my-1">Data (<?=count($isi)?>)</h6></td>
			</tr>
			<?php $num=0; foreach($isi as $i) : ?>
			<tr>
				<td class="align-top"><?= ++$num ?>.</td>
				<td>
					<div class="form-row">
						<div class="col">
							<div class="form-row mb-1">
								<div class="col">Jenis Data</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">Detail</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">Format Data</div>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="form-row">
						<div class="col">
							<div class="form-row mb-1">
								<div class="col"><?= $i['jenis_data'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col"><?= $i['detail'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col"><?= $i['format_data'] ?></div>
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
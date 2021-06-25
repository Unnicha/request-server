	<div class="modal-header">
		<h5 class="modal-title"><?= $judul ?></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body p-3">
		<div class="container-fluid p-0">
			<table class="table table-striped table-detail mb-3" id="data">
				<tbody>
					<tr>
						<td scope="row">Tanggal Input</td>
						<td>: <?= $proses['tanggal_proses'] ?></td>
					</tr>
					<tr>
						<td scope="row">Akuntan</td>
						<td>: <?= $proses['nama'] ?></td>
					</tr>
					<tr>
						<td scope="row">Klien</td>
						<td>: <?= $proses['nama_klien'] ?></td>
					</tr>
					<tr>
						<td scope="row">Jenis Data</td>
						<td>: <?= $proses['jenis_data'] ?></td>
					</tr>
					<tr>
						<td scope="row">Detail</td>
						<td>: <?= $proses['detail'] ?></td>
					</tr>
					<tr>
						<td scope="row">Nama Tugas</td>
						<td>: <?= $proses['nama_tugas'] ?></td>
					</tr>
					<tr>
						<td scope="row">Mulai Proses</td>
						<td>: <?= $proses['tanggal_mulai'] ?></td>
					</tr>
					<tr>
						<td scope="row">Selesai Proses</td>
						<td>: <?= $proses['tanggal_selesai'] ?></td>
					</tr>
					<tr>
						<td scope="row">Status</td>
						<td>: <?= $add['status'] ?></td>
					</tr>
					<tr>
						<td scope="row">Durasi</td>
						<td>: <?= $add['durasi'] ?></td>
					</tr>
					<tr>
						<td scope="row">Standar durasi</td>
						<td>: <?= $add['standar'] ?></td>
					</tr>
					<tr>
						<td scope="row">Keterangan</td>
						<td>: <?= $proses['ket_proses'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

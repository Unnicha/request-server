<div class="modal-header px-4">
	<h4 class="modal-title"><?= $judul ?></h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-3">
	<div class="container-fluid p-0">
		<h5 class="px-3">Detail Tugas</h5>
		<div class="row mb-3">
			<div class="col">
				<table class="table table-detail">
					<tbody>
						<tr>
							<td scope="row">Nama Data</td>
							<td><?= $proses['jenis_data'] ?></td>
						</tr>
						<tr>
							<td scope="row">Detail</td>
							<td><?= $proses['detail'] ?></td>
						</tr>
						<tr>
							<td scope="row">Output</td>
							<td><?= $proses['nama_tugas'] ?></td>
						</tr>
						<tr>
							<td scope="row">Klien</td>
							<td><?= $proses['nama_klien'] ?></td>
						</tr>
						<tr>
							<td scope="row">Akuntan</td>
							<td><?= $proses['nama'] ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<h5 class="px-3">Detail Proses</h5>
		<table class="table table-striped table-responsive-md" id="data">
			<thead class="text-center">
				<tr>
					<th>Tanggal Input</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Status</th>
					<th>Durasi</th>
					<th>Estimasi</th>
					<th>Ket</th>
				</tr>
			</thead>
			
			<tbody class="text-center">
				<tr>
					<td><?= $proses['tanggal_proses'] ?></td>
					<td><?= $proses['tanggal_mulai'] ?></td>
					<td><?= $proses['tanggal_selesai'] ?></td>
					<td><?= ($proses['tanggal_selesai']) ? 'Selesai' : 'Belum' ?></td>
					<td></td>
					<td><?= $add['standar'] ?></td>
					<td><?= $proses['ket_proses'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

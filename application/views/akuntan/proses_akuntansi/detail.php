<div class="modal-header px-4">
	<h3 class="modal-title"><?= $judul ?></h3>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-4" style="background-color: #e8e7ea;">
	<div class="container-fluid p-0">
		<div class="card card-shadow mb-4">
			<div class="card-body">
				<h5 class="card-title">Overview</h5>
				<div class="row">
					<div class="col">
						<table class="table table-detail">
							<tbody>
								<tr>
									<td class="detail-title" scope="row">Klien</td>
									<td><?= $pengiriman['nama_klien'] ?></td>
								</tr>
								<tr>
									<td class="detail-title" scope="row">Nama Data</td>
									<td><?= $pengiriman['jenis_data'] ?></td>
								</tr>
								<tr>
									<td class="detail-title" scope="row">Detail</td>
									<td><?= $pengiriman['detail'] ?></td>
								</tr>
								<tr>
									<td class="detail-title" scope="row">Pengiriman Terakhir</td>
									<td><?= $pengiriman['last'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col">
						<table class="table table-detail">
							<tbody>
								<tr>
									<td class="detail-title" scope="row">Output</td>
									<td><?= $pengiriman['nama_tugas'] ?></td>
								</tr>
								<?php if($_SESSION['status'] != 'todo') : ?>
								<tr>
									<td class="detail-title" scope="row">Durasi</td>
									<td><?= $total ?></td>
								</tr>
								<?php endif ?>
								<tr>
									<td class="detail-title" scope="row">Estimasi</td>
									<td><?= $pengiriman['estimasi'] ?></td>
								</tr>
								<tr>
									<td class="detail-title" scope="row">Status Proses</td>
									<td><?= $pengiriman['badge'] ?></td>
								</tr>
								<tr>
									<td class="detail-title" scope="row">Akuntan</td>
									<td><?= $pengiriman['nama'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card card-shadow">
			<div class="card-body">
				<h5 class="card-title">Detail Proses</h5>
				<table class="table table-striped table-responsive-md mb-0">
					<thead class="text-center">
						<tr>
							<th>Tanggal Input</th>
							<th>Mulai</th>
							<th>Selesai</th>
							<th>Durasi</th>
							<th>Ket</th>
						</tr>
					</thead>
					
					<tbody class="text-center">
						<?php if($proses) :
							foreach($proses as $i => $p) : ?>
							<tr>
								<td><?= $p['tanggal_proses'] ?></td>
								<td><?= $p['tanggal_mulai'] ?></td>
								<td><?= $p['tanggal_selesai'] ?></td>
								<td><?= $durasi[$i] ?></td>
								<td><?= $p['ket_proses'] ?></td>
							</tr>
						<?php endforeach; else : ?>
							<tr>
								<td colspan="6">Belum ada proses</td>
							</tr>
						<?php endif ?>
						<tr class="text-center">
							<th colspan="2"></th>
							<th>Total durasi</th>
							<th><?=$total?></th>
							<th></th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal-header px-4">
	<h4 class="modal-title"><?= $judul ?></h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-4">
	<div class="container-fluid p-0">
		<div class="card-deck mb-4">
			<div class="card card-shadow">
				<div class="card-body">
					<h5 class="card-title">Detail Tugas</h5>
					<table class="table table-detail">
						<tbody>
							<tr>
								<td scope="row">Akuntan</td>
								<td><?= $pengiriman['nama'] ?></td>
							</tr>
							<tr>
								<td scope="row">Klien</td>
								<td><?= $pengiriman['nama_klien'] ?></td>
							</tr>
							<tr>
								<td scope="row">Nama Data</td>
								<td><?= $pengiriman['jenis_data'] ?></td>
							</tr>
							<tr>
								<td scope="row">Detail</td>
								<td><?= $pengiriman['detail'] ?></td>
							</tr>
							<tr>
								<td scope="row">Output</td>
								<td><?= $pengiriman['nama_tugas'] ?></td>
							</tr>
							<?php if($_SESSION['status'] != 'todo') : ?>
							<tr>
								<td scope="row">Durasi</td>
								<td><?= $total ?></td>
							</tr>
							<?php endif ?>
							<tr>
								<td scope="row">Estimasi</td>
								<td><?= $pengiriman['estimasi'] ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="card card-shadow">
				<div class="card-body">
					<h5 class="card-title">Detail Pengiriman</h5>
					<table class="table table-striped">
						<thead class="text-center">
							<tr>
								<th>No.</th>
								<th>Tanggal Pengiriman</th>
								<?php if($pengiriman['format_data'] == 'Hardcopy') : ?>
									<th>Tanggal Ambil</th>
								<?php endif ?>
							</tr>
						</thead>
						
						<tbody class="text-center">
							<?php foreach($detail as $i => $p) : ?>
							<tr>
								<td><?=$i+1?>.</td>
								<td><?=$p['tanggal_pengiriman'] ?></td>
								<?php if($pengiriman['format_data'] == 'Hardcopy') : ?>
									<td><?=$p['file']?></td>
								<?php endif ?>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
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
							<th>Status</th>
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
								<td><?= $add[$i]['badge'] ?></td>
								<td><?= $add[$i]['durasi'] ?></td>
								<td><?= $p['ket_proses'] ?></td>
							</tr>
						<?php endforeach; else : ?>
							<tr>
								<td colspan="6">Belum ada proses</td>
							</tr>
						<?php endif ?>
						<tr class="text-center">
							<th colspan="3"></th>
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

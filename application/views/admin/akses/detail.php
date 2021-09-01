<div class="modal-header">
	<h5 class="modal-title"><?=$judul?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container-fluid p-0">
		<table class="table table-detail">
			<tbody>
				<tr>
					<td scope="row">Nama Akuntan</td>
					<td><?= $akses['nama']; ?></td>
				</tr>
				<tr>
					<td scope="row">Tahun Akses</td>
					<td><?= $akses['tahun']; ?></td>
				</tr>
				<tr>
					<td scope="row">Bulan Mulai</td>
					<td><?= $akses['nama_bulan']; ?></td>
				</tr>
			</tbody>
		</table>
		
		<div class="row mt-4">
			<div class="col">
				<h5>Akses Data</h5>
			</div>
		</div>
		
		<table class="table table-striped">
			<thead class="text-center">
				<tr>
					<th>Akuntansi</th>
					<th>Perpajakan</th>
					<th>Lainnya</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php for($i=0; $i<$akses['jum']; $i++) : ?>
				<tr>
					<td><?= isset($akuntansi[$i])	? $akuntansi[$i]['nama_klien']	: '' ?></td>
					<td><?= isset($perpajakan[$i])	? $perpajakan[$i]['nama_klien']	: '' ?></td>
					<td><?= isset($lainnya[$i])		? $lainnya[$i]['nama_klien']	: '' ?></td>
				</tr>
				<?php endfor ?>
			</tbody>
		</table>
	</div>
</div>
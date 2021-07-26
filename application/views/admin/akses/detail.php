<div class="modal-header">
	<h5 class="modal-title"><?=$judul?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container-fluid p-0">
		<table class="table table-striped table-detail mb-0">
			<tbody>
				<tr>
					<td scope="row" width="40%">Nama Akuntan</td>
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
				<tr>
					<td colspan="2"><b>Akses Data :</b></td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-bordered table-striped table-detail">
			
			<tbody>
				<tr class="text-center" style="font-weight:700">
					<td>Akuntansi</td>
					<td>Perpajakan</td>
					<td>Lainnya</td>
				</tr>
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
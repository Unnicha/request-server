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
				<td><?= $pengiriman['tanggal_permintaan']; ?></td>
			</tr>
			<tr>
				<td scope="row">Permintaan / Pengiriman</td>
				<td><?= $pengiriman['request'].' / '.$pengiriman['pembetulan'] ?></td>
			</tr>
			
			<!-- DATA -->
			<tr>
				<td scope="row"><h6 class="my-1">Data (<?= count($isi) ?>)</h6></td>
				<td>
					<?php if($button == true) : ?>
					<a href="<?=base_url('akuntan/penerimaan_data_lainnya/konfirmasi/'.$pengiriman['id_pengiriman'])?>" class="btn btn-sm btn-primary">Konfirmasi Data</a>
					<?php endif ?>
				</td>
			</tr>
			
			<?php $num=0; foreach($isi as $i) : ?>
			<tr>
				<td colspan="2">
					<div class="form-row">
						<div class="col-1 text-center">
							<b><?= ++$num . '.' ?></b>
						</div>
						<div class="col">
							<div class="form-row mb-1">
								<div class="col-5">Jenis Data</div>
								<div class="col">: <?= $i['jenis_data'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col-5">Detail</div>
								<div class="col">: <?= $i['detail'] ?></div>
							</div>
							
							<?php if($i['tanggal_pengiriman']) : ?>
							<div class="form-row mb-1">
								<div class="col-5">Tanggal Pengiriman</div>
								<div class="col">: <?= $i['tanggal_pengiriman'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col-5"><?= $add[$num]['file_title'] ?></div>
								<div class="col">: <?= $add[$num]['file'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col-5">Note</div>
								<div class="col">: <?= $i['ket_file'] ?></div>
							</div>
							<?php else : ?>
							<div class="form-row mb-1">
								<div class="col-5">Format Data</div>
								<div class="col">: <?= $i['format_data'] ?></div>
							</div>
							<?php endif ?>
							
							<div class="form-row mb-1">
								<div class="col-5">Status</div>
								<div class="col">: <?= $add[$num]['status'] ?></div>
							</div>
							<?php if($i['status'] == 2) : ?>
							<div class="form-row mb-1">
								<div class="col-5">Keterangan</div>
								<div class="col">: <?= $i['ket_status'] ?></div>
							</div>
							<?php endif ?>
						</div>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
</div>
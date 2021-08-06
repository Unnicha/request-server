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
				<td><?= $pengiriman['tanggal_permintaan']; ?></td>
			</tr>
			<tr>
				<td colspan="2">Permintaan</td>
				<td><?= $pengiriman['request'] ?></td>
			</tr>
			<tr>
				<td colspan="2">Pengiriman</td>
				<td><?= $pengiriman['pembetulan'] ?></td>
			</tr>
			
			<!-- DATA -->
			<tr>
				<td colspan="2" style="border-right-color:#fff">
					<h6 class="my-1">Data (<?= count($isi) ?>)</h6>
				</td>
				<td>
					<?php if($button == true) : ?>
						<a href="<?=base_url('klien/pengiriman_data_lainnya/lengkapi/'.$pengiriman['id_pengiriman'])?>" class="btn btn-sm btn-primary float-right">Lengkapi Data</a>
					<?php endif ?>
				</td>
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
							
							<?php if($i['tanggal_pengiriman']) : ?>
							<div class="form-row mb-1">
								<div class="col">Tanggal Pengiriman</div>
							</div>
							<div class="form-row mb-1">
								<div class="col"><?= $add[$num]['file_title'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col">Note</div>
							</div>
							<?php else : ?>
							<div class="form-row mb-1">
								<div class="col">Format Data</div>
							</div>
							<?php endif ?>
							
							<div class="form-row mb-1">
								<div class="col">Status</div>
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
							
							<?php if($i['tanggal_pengiriman']) : ?>
							<div class="form-row mb-1">
								<div class="col"><?= $i['tanggal_pengiriman'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col"><?= $add[$num]['file'] ?></div>
							</div>
							<div class="form-row mb-1">
								<div class="col"><?= $i['ket_file'] ? $i['ket_file'] : '<br>' ?></div>
							</div>
							<?php else : ?>
							<div class="form-row mb-1">
								<div class="col"><?= $i['format_data'] ?></div>
							</div>
							<?php endif ?>
							
							<div class="form-row mb-1">
								<div class="col"><?= $add[$num]['status'] ?></div>
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
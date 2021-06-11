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
				<td scope="row">Tanggal Pengiriman</td>
				<td><?= $pengiriman['tanggal_pengiriman']; ?></td>
			</tr>
			<tr>
				<td scope="row">Bulan / Tahun</td>
				<td><?= $bulan .' / '. $pengiriman['tahun']; ?></td>
			</tr>
			<tr>
				<td scope="row">Permintaan / Pengiriman</td>
				<td><?= $pengiriman['request'].' / '.sprintf("%02s", $pengiriman['pembetulan'] + 1) ?></td>
			</tr>
			
			<!-- DATA -->
			<tr>
				<td scope="row"><h6 class="my-1">Data (<?=$jum_data?>)</h6></td>
				<td>
					<?php if($lengkap == false) : ?>
					<a href="<?=base_url('akuntan/penerimaan_data_akuntansi/konfirmasi/'.$pengiriman['id_pengiriman'])?>" class="btn btn-sm btn-primary">Konfirmasi Data</a>
					<?php endif ?>
				</td>
			</tr>
			<?php for($i=0; $i<$jum_data; $i++) : ?>
			<tr>
				<td colspan="2">
					<div class="form-row">
						<div class="col-1 text-center">
							<b><?= $i+1 ?>.</b>
						</div>
						<div class="col">
							<div class="form-row">
								<div class="col-5">Jenis Data</div>
								<div class="col">: <?= $jenis_data[$i]['jenis_data'] ?></div>
							</div>
							<div class="form-row">
								<div class="col-5">Detail</div>
								<div class="col">: <?= $detail[$i] ?></div>
							</div>
							<div class="form-row">
								<?php if($format_data[$i] == 'Hardcopy') : ?>
									<div class="col-5">Tanggal Ambil</div>
									<div class="col">: <?= $file[$i] ?></div>
								<?php else : ?>
									<div class="col-5">File</div>
									<div class="col">
										: <a href="<?=base_url() . $lokasi . $file[$i]; ?>"><?=$file[$i] ?></a>
									</div>
								<?php endif ?>
							</div>
							<div class="form-row">
								<div class="col-5">Note</div>
								<div class="col">: <?= $keterangan[$i] ?></div>
							</div>
							<div class="form-row">
								<div class="col-5">Status</div>
								<div class="col">
									<?php if($status) : if($status[$i] == 'lengkap') : ?>
										: <span class="badge badge-success">Sudah Dikonfirmasi</span>
									<?php elseif($status[$i] == 'kurang') : ?>
										: <span class="badge badge-danger">Kurang Lengkap</span>
									<?php else : ?>
										: <span class="badge badge-warning">Belum Dikonfirmasi</span>
									<?php endif; else : ?>
										: <span class="badge badge-warning">Belum Dikonfirmasi</span>
									<?php endif ?>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<?php endfor ?>
		</tbody>
	</table>
	</div>
</div>
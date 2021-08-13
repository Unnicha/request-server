<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif ?>
	
	<div class="row p-3">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<div class="card card-shadow mx-3 mb-4">
		<div class="card-body">
			<div class="row mb-2">
				<div class="col">
					<h5>Detail Permintaan</h5>
				</div>
			</div>
			
			<table class="table table-detail">
				<tbody>
					<tr>
						<td>Jenis Data</td>
						<td><?=$detail['jenis_data']?></td>
					</tr>
					<tr>
						<td>Detail</td>
						<td><?=$detail['detail']?></td>
					</tr>
					<tr>
						<td>Format Data</td>
						<td><?=$detail['format_data']?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td><?= $detail['badge'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card card-shadow mx-3 mb-4">
		<div class="card-body">
			<div class="row mb-2">
				<div class="col">
					<h5>Detail Pengiriman</h5>
				</div>
			</div>
			
			<table class="table table-striped">
				<thead class="text-center">
					<tr>
						<th>Pengiriman</th>
						<th>Tanggal pengiriman</th>
						<th><?= ($detail['format_data'] == 'Softcopy') ? 'File' : 'Tanggal Ambil' ?></th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php
						if($pengiriman) :
							foreach($pengiriman as $p) : ?>
					<tr>
						<td><?=$p['pengiriman']?></td>
						<td><?=$p['tanggal_pengiriman']?></td>
						<td>
							<?php if($detail['format_data'] == 'Softcopy') : ?>
								<a href="<?=base_url($link.$p['file'])?>"><?=$p['file']?></a>
							<?php else : $p['file'] ?>
							<?php endif ?>
						</td>
						<td class="text-left"><?=$p['ket_pengiriman']?></td>
					</tr>
						<?php endforeach; else : ?>
					<tr>
						<td colspan="5">Belum ada pengiriman</td>
					</tr>
					<?php endif ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row mb-4">
		<div class="col">
			<a href="<?=base_url('admin/permintaan/permintaan_data_akuntansi')?>" class="btn btn-secondary mr-1">Kembali</a>
		</div>
	</div>
</div>

<div class="modal fade" id="modalKonfirm" tabindex="0" aria-labelledby="konfirmLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" id="konfirmShow" style="width:400px">
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		if( $('.notification').data('val') == 'yes' ) {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		$('[data-toggle="tooltip"]').mouseenter(function() {
			$(this).tooltip();
		});
	})
</script>
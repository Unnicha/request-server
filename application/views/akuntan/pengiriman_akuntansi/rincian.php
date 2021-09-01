<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h4><?= $judul ?></h4>
		</div>
	</div>
	
	<div class="card card-shadow">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h5>Detail Permintaan</h5>
				</div>
			</div>
			
			<table class="table table-detail mb-0">
				<tbody>
					<tr>
						<td scope="row" width="35%">Jenis Data</td>
						<td><?=$detail['jenis_data']?></td>
					</tr>
					<tr>
						<td scope="row">Detail</td>
						<td><?=$detail['detail']?></td>
					</tr>
					<tr>
						<td scope="row">Format Data</td>
						<td><?=$detail['format_data']?></td>
					</tr>
					<tr>
						<td scope="row">Status</td>
						<td><?= $detail['badge'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card card-shadow mt-4">
		<div class="card-header">
			<div class="row">
				<div class="col">
					<h5 class="mb-0">History Pengiriman</h5>
				</div>
				<div class="col">
					<?= $detail['button'] ?>
				</div>
			</div>
		</div>
		
		<div class="card-body p-0">
			<table class="table table-striped mb-0">
				<thead class="text-center">
					<tr>
						<th>Pengiriman ke</th>
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
								<a href="<?=$link.$p['file']?>"><?=$p['file']?></a>
							<?php else : echo $p['file'] ?>
							<?php endif ?>
						</td>
						<td><?=$p['ket_pengiriman']?></td>
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
	
	<div class="row mt-4">
		<div class="col">
			<a href="<?=base_url('akuntan/pengiriman_data_akuntansi')?>" class="btn btn-secondary mr-1">Kembali</a>
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
		
		$('.btn-konfirm').click(function() {
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>akuntan/pengiriman_data_akuntansi/konfirmasi',
				data	: {
					'id'		: $(this).data('id'),
					'status'	: $(this).data('status'),
				},
				success	: function( e ) {
					$('#modalKonfirm').modal('show');
					$('#konfirmShow').html( e );
				}
			})
		})
		$('#konfirmShow').on('click', '.btn-fix', function() {
			var id		= $(this).data('id');
			var stat	= $(this).data('status');
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>akuntan/pengiriman_data_akuntansi/fix',
				data	: {
					'id'	: id,
					'stat'	: stat
				},
				success	: function() {
					$('#modalKonfirm').modal('hide');
					window.location.assign("<?= base_url();?>akuntan/pengiriman_data_akuntansi/detail_pengiriman/"+id);
				}
			})
		})
	})
</script>
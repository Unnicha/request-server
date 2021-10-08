<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h4><?= $judul ?></h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card-deck">
				<div class="card card-shadow">
					<div class="card-body">
						<div class="row mb-2">
							<div class="col">
								<h5>Detail Permintaan</h5>
							</div>
						</div>
						
						<table class="table table-detail mb-0">
							<tbody>
								<tr>
									<td>Nama Klien</td>
									<td><?=$detail['nama_klien']?></td>
								</tr>
								<tr>
									<td>Permintaan ke</td>
									<td><?=$detail['request']?></td>
								</tr>
								<tr>
									<td>Tanggal Permintaan</td>
									<td><?=$detail['tanggal_permintaan']?></td>
								</tr>
								<tr>
									<td>Requestor</td>
									<td><?= $detail['nama'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="card card-shadow">
					<div class="card-body">
						<div class="row mb-2">
							<div class="col">
								<h5>Detail Data</h5>
							</div>
						</div>
						
						<table class="table table-detail mb-0">
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
			</div>
		</div>
	</div>
	
	<div class="card card-shadow mt-4">
		<div class="card-body">
			<div class="row mb-2">
				<div class="col">
					<h5>History Pengiriman</h5>
				</div>
				<div class="col-auto">
					<?= $detail['button'] ?>
				</div>
			</div>
			
			<table class="table table-striped">
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
								<a href="<?=base_url($link.$p['file'])?>"><?=$p['file']?></a>
							<?php else : echo $p['file'] ?>
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
	
	<div class="row mt-4">
		<div class="col">
			<a href="<?=base_url('admin/pengiriman/pengiriman_data_perpajakan')?>" class="btn btn-secondary mr-1">Kembali</a>
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
				url		: '<?= base_url(); ?>admin/pengiriman/pengiriman_data_perpajakan/konfirmasi',
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
				url		: '<?= base_url(); ?>admin/pengiriman/pengiriman_data_perpajakan/fix',
				data	: {
					'id'	: id,
					'stat'	: stat
				},
				success	: function() {
					$('#modalKonfirm').modal('hide');
					window.location.assign("<?= base_url();?>admin/pengiriman/pengiriman_data_perpajakan/detail/"+id);
				}
			})
		})
	})
</script>
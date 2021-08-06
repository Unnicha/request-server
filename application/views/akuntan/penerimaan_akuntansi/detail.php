<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="text-center"><?= $judul ?></h2>
	
	<hr class="my-0">
	
	<div class="row row-child mt-2 mb-3">
		<div class="col">
			<div class="row">
				<div class="col">
					<table class="table table-borderless" style="width:fit-content">
						<tbody>
							<tr>
								<td>Jenis Data</td>
								<td> : <?=$detail['jenis_data']?></td>
							</tr>
							<tr>
								<td>Detail</td>
								<td> : <?=$detail['detail']?></td>
							</tr>
							<tr>
								<td>Format Data</td>
								<td> : <?=$detail['format_data']?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td> : <?= $detail['badge'] ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<table class="table table-sm table-striped table-bordered table-responsive-sm">
						<thead class="text-center">
							<tr>
								<th>Pengiriman ke</th>
								<th>Tanggal pengiriman</th>
								<th><?= $detail['format_data'] == 'Softcopy' ? 'File' : 'Tanggal Ambil' ?></th>
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
								<td><?=$p['file']?></td>
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
			
			<div class="row mb-3">
				<div class="col">
					<a href="#" class="btn btn-danger btn-konfirm" data-id="<?=$detail['id_data']?>" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batalkan</a>
					<a href="<?=base_url()?>akuntan/penerimaan_data_akuntansi" class="btn btn-secondary">Kembali</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalKonfirm" tabindex="0" aria-labelledby="konfirmLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" style="width:400px">
			<div class="modal-header pl-4">
				<h5 class="modal-title" id="konfirmLabel">Batal Konfirmasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body py-4 px-4">
				<div class="row mb-4">
					<div class="col">
						<font size="4">
							Batalkan konfirmasi data?
						</font>
					</div>
				</div>
				<div class="idData" style="display:none"></div>
				<div class="row float-right">
					<div class="col">
						<a href="#" class="btn btn-primary btn-fix">Batalkan</a>
					</div>
				</div>
			</div>
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
			$('#modalKonfirm').modal('show');
			$('.idData').html( $(this).data('id') );
		})
		$('.btn-fix').click(function() {
			var id = $('.idData').html();
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>akuntan/penerimaan_data_akuntansi/batal',
				data	: 'id='+id,
				success	: function() {
					$('#modalKonfirm').modal('hide');
					window.location.assign("<?= base_url();?>akuntan/penerimaan_data_akuntansi");
				}
			})
		})
	})
</script>
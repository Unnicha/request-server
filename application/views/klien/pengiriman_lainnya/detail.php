<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="text-center"><?= $judul ?></h2>
	
	<hr class="my-0">
	
	<div class="row row-child mt-2 mb-3">
		<div class="col">
			<div class="row">
				<div class="col-lg">
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
				
				<div class="col-lg">
					<?php if($detail['status'] != 'yes') : ?>
					<div class="card mt-2 mb-3">
						<div class="card-body p-3">
							<div class="form-group row">
								<div class="col">
									<h5>Kirim Baru</h5>
								</div>
							</div>
							
							<form action="" method="post" enctype="multipart/form-data">
								<input type="hidden" name="format_data" value="<?=$detail['format_data']?>">
								<input type="hidden" name="id_data" value="<?=$detail['id_data']?>">
								
								<div class="form-group row">
								<?php if($detail['format_data'] == 'Softcopy') : ?>
									<div class="col">
										<div class="custom-file">
											<input type="file" name="files" class="custom-file-input" required>
											<label class="custom-file-label" data-browse="Cari">Pilih file</label>
										</div>
										<small class="form-text text-danger"><?= form_error('files', '<p class="mb-0">', '</p>') ?></small>
										<small class="form-text px-2">Format .xls, .xlsx, .csv, .pdf, .rar, .zip</small>
									</div>
								<?php else : ?>
									<div class="col">
										<div class="input-group kalender">
											<input type="text" name="tanggal_ambil" class="form-control docs-date" data-toggle="datepicker" autocomplete="off" placeholder="Tanggal Ambil Data" required readonly>
											<div class="input-group-append">
												<a class="btn btn-outline-secondary reset-date px-2" data-toggle="tooltip" data-placement="bottom" title="Reset Tanggal">
													<i class="bi bi-x-circle" style="font-size:20px"></i>
												</a>
											</div>
										</div>
										<small class="form-text text-danger"><?= form_error('tanggal_ambil', '<p class="mb-0">', '</p>') ?></small>
									</div>
								<?php endif ?>
								</div>
								
								<div class="form-group row">
									<div class="col">
										<textarea type="text" name="keterangan" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Keterangan"></textarea>
									</div>
								</div>
								
								<!-- Tombol Simpan -->
								<div class="row">
									<div class="col">
										<button type="submit" class="btn btn-primary float-right">Kirim</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php endif ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<table class="table table-striped">
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
					<a href="<?=base_url()?>klien/pengiriman_data_lainnya" class="btn btn-secondary mr-1">Kembali</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/bs-custom-file-input.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>
<script>
	$(document).ready(function () {
		if( $('.notification').data('val') == 'yes' ) {
			$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		bsCustomFileInput.init();
		
		//memanggil date picker
		const myDatePicker = $('[data-toggle="datepicker"]').datepicker({
			autoHide	: true,
			format		: 'dd-mm-yyyy',
			startDate	: '<?= date('d-m-Y') ?>',
		});
		
		$(".reset-date").click(function() {
			$(this).closest('.kalender').find("input[type=text]").datepicker('reset');
		});
		
		$('[data-toggle="tooltip"]').mouseenter(function() {
			$(this).tooltip();
		});
	})
</script>
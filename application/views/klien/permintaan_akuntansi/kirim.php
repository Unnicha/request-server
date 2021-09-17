<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="content-header">
		<div class="row">
			<div class="col">
				<h3><?=$judul?></h3>
			</div>
			<div class="col-auto">
				<a href="<?=base_url().$back?>" class="btn btn-secondary mr-1">Kembali</a>
			</div>
		</div>
	</div>
	
	<div class="row mb-sm-4">
		<div class="col">
			<div class="card-deck">
				<div class="card card-shadow">
					<div class="card-body p-4">
						<h5 class="card-title">Overview</h5>
						
						<table class="table table-detail mb-0">
							<tbody>
								<tr>
									<td class="detail-title">Jenis Data</td>
									<td><?=$detail['jenis_data']?></td>
								</tr>
								<tr>
									<td class="detail-title">Detail</td>
									<td><?=$detail['detail']?></td>
								</tr>
								<tr>
									<td class="detail-title">Format Data</td>
									<td><?=$detail['format_data']?></td>
								</tr>
								<tr>
									<td class="detail-title">Status</td>
									<td><?= $detail['badge'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<?php if($detail['status_kirim'] != 'yes') : ?>
					<div class="card card-round shadow">
						<div class="card-body p-4">
							<h5 class="card-title">Kirim Baru</h5>
							
							<form action="" method="post" enctype="multipart/form-data">
								<input type="hidden" name="format_data" value="<?=$detail['format_data']?>">
								<input type="hidden" name="id_data" value="<?=$detail['id_data']?>">
								
								<div class="form-group row">
								<?php if($detail['format_data'] == 'Softcopy') : ?>
									<div class="col">
										<small class="form-text pb-2 mt-0">Format file : <b>.xls, .xlsx, .csv, .pdf, .rar, .zip</b></small>
										<div class="custom-file">
											<input type="file" name="files" class="custom-file-input" required>
											<label class="custom-file-label" data-browse="Cari">Pilih file</label>
										</div>
										<small class="form-text text-danger"><?= $this->session->flashdata('flash'); ?></small>
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
	</div>
	
	<div class="row mb-4">
		<div class="col">
			<div class="card card-shadow">
				<div class="card-header">
					<h5 class="card-header-title">History Pengiriman</h5>
				</div>
				<div class="card-body p-0">
					<table class="table table-striped table-responsive-sm mb-0">
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
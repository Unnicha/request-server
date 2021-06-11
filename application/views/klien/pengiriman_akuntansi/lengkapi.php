<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mb-3">
		<div class="col px-lg-4">
			<form action="" method="post">
				<input type="hidden" name="id_pengiriman" value="<?=$id_pengiriman?>">
				
				<?php for($i=0; $i<$jum_data; $i++) : ?>
				<div class="form-row pt-1 mt-2">
					<label class="col-form-label pt-0"><b><?= $i+1 ?>.</b></label>
					
					<div class="col col-lg-5">
						<div class="form-row mb-2">
							<div class="col-4">Jenis Data</div>
							<div class="col">: <?=$jenis_data[$i]['jenis_data']?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">Detail</div>
							<div class="col">: <?=$detail[$i]?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">Format Data</div>
							<div class="col">: <?=$format_data[$i]?></div>
						</div>
						<!-- STATUS -->
						<?php
							if($status[$i] == 'lengkap') {
								$badge = '<span class="badge badge-success">Sudah Dikonfirmasi</span><br>';
							} elseif($status[$i] == 'kurang') {
								$badge = '<span class="badge badge-danger">Kurang Lengkap</span><br>';
							} else {
								$badge = '<span class="badge badge-warning">Belum Dikonfirmasi</span><br>';
							}
						?>
						<div class="form-row my-2">
							<div class="col-4">Status</div>
							<div class="col">: <?=$badge?></div>
						</div>
						<?php if($status[$i] == 'kurang') : ?>
						<div class="form-row my-2">
							<div class="col-4">Keterangan</div>
							<div class="col">: <?=$keterangan[$i]?></div>
						</div>
						<?php endif ?>
					</div>
					
					<div class="col col-lg-4">
						<?php if($status[$i] == 'kurang') : ?>
						<div class="form-group row">
							<?php if($format_data[$i] == 'Softcopy') : ?>
							<!-- File -->
							<div class="col">
								<div class="custom-file">
									<input type="file" name="files[]" class="custom-file-input" required>
									<label class="custom-file-label" data-browse="Cari">Pilih file</label>
								</div>
								<small class="form-text px-2">Format .xls, .xlsx, .csv, .pdf, .rar, .zip</small>
							</div>
							<?php else : ?>
							<!-- Tanggal Pengambilan -->
							<div class="col">
								<input type="text" name="tanggal_ambil[]" class="form-control docs-date" placeholder="Tanggal Ambil Data" data-toggle="datepicker" required>
							</div>
							<?php endif ?>
						</div>
						
						<div class="form-group row">
							<div class="col">
								<textarea type="text" name="keterangan[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Keterangan"></textarea>
							</div>
						</div>
						<?php else : ?>
						<div class="form-group row">
							<?php if($format_data[$i] == 'Softcopy') : ?>
							<!-- File -->
							<div class="col">
								<input type="text" name="file[]" class="form-control" value="<?=$file[$i]?>" readonly>
							</div>
							<?php else : ?>
							<!-- Tanggal Pengambilan -->
							<div class="col">
								<input type="text" name="tanggal_ambil[]" class="form-control" value="<?=$file[$i]?>" readonly>
							</div>
							<?php endif ?>
						</div>
						
						<div class="form-group row">
							<div class="col">
								<textarea type="text" name="keterangan[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" readonly><?=$keterangan[$i]?></textarea>
							</div>
						</div>
						<?php endif ?>
					</div>
				</div>
				
				<hr class="my-0">
				<?php endfor ?>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">Kirim</button>
						<a href="<?= base_url(); ?>klien/pengiriman_data_akuntansi" class="btn btn-secondary">
							Batal
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/bs-custom-file-input.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>
<script>
	$(document).ready(function () {
		bsCustomFileInput.init();
		
		//memanggil date picker
		const myDatePicker = $('[data-toggle="datepicker"]').datepicker({
			autoHide: true,
			format: 'dd-mm-yyyy',
		});
	})
</script>
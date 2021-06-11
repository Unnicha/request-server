<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mb-3">
		<div class="col">
			<?php if($this->session->flashdata('flash')) : ?>
			<div class="row">
				<div class="col">
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?= $this->session->flashdata('flash'); ?>.
					</div>
				</div>
			</div>
			<?php endif; ?>

			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_permintaan" value="<?=$permintaan['id_permintaan']?>">
				<input type="hidden" name="format_data" value="<?=$permintaan['format_data']?>">
				
				<?php for($i=0; $i<$jum_data; $i++) : ?>
				<div class="form-row mt-3">
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
					</div>
					
					<div class="col col-lg-5">
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
								<textarea type="text" name="keterangan[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Tambahkan Keterangan"></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<hr class="my-0">
				<?php endfor ?>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">
							Kirim
						</button>
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
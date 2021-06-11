<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child my-3">
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
				
				<?php for($i=0; $i<$jum_data; $i++) : ?>
				<div class="form-row mb-4">
					<label class="col-form-label"><b><?= $i+1 ?>.</b></label>
					<div class="col">
						<div class="form-row mb-2">
							
							<!-- Jenis Data -->
							<div class="col-4">
								<input type="text" name="kode_jenis[]" class="form-control" value="<?=$jenis_data[$i]['jenis_data']?>" readonly>
							</div>
								
							<!-- Keterangan -->
							<div class="col">
								<textarea type="text" name="keterangan[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" readonly><?=$keterangan[$i]?></textarea>
							</div>
							
							<!-- Format Data -->
							<div class="col-4">
								<input type="text" name="format_data[]" class="form-control" value="<?=$format_data[$i]?>" readonly>
							</div>
						</div>
						
						<div class="form-row">
							<?php if($format_data[$i] == 'Softcopy') : ?>
							<!-- File -->
							<div class="col-4">
								<div class="custom-file">
									<input type="file" name="files[]" class="custom-file-input" required>
									<label class="custom-file-label" data-browse="Cari">Pilih file</label>
								</div>
								<small class="form-text px-2">Format .xls, .xlsx, .csv, .pdf, .rar, .zip</small>
							</div>
							<?php else : ?>
							<!-- Tanggal Pengambilan -->
							<div class="col-4">
								<input type="text" name="tanggal_ambil[]" class="form-control docs-date" placeholder="Tanggal Ambil Data" data-toggle="datepicker" required>
							</div>
							<?php endif ?>
								
							<!-- Keterangan -->
							<div class="col-4">
								<textarea type="text" name="keterangan2[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Tambahkan Keterangan"></textarea>
							</div>
						</div>
					</div>
				</div>
				<?php endfor ?>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">
							Kirim
						</button>
						<a href="<?= base_url(); ?>klien/permintaan_data_lainnya" class="btn btn-secondary">
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
			autoHide	: true,
			format		: 'dd-mm-yyyy',
		});
	})
</script>
<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mb-3">
		<div class="col">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_permintaan" value="<?=$isi['id_kirim']?>">
				<input type="hidden" name="id_data" value="<?=$isi['id_data']?>">
				<input type="hidden" name="format_data[]" value="<?=$isi['format_data']?>">
				<input type="hidden" name="tipe" value="baru">
				
				<div class="row mt-3">
					<div class="col col-lg-5">
						<div class="form-row mb-2">
							<div class="col-4">Jenis Data</div>
							<div class="col">: <?=$isi['jenis_data']?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">Detail</div>
							<div class="col">: <?=$isi['detail']?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">Format Data</div>
							<div class="col">: <?=$isi['format_data']?></div>
						</div>
					</div>
					
					<div class="col col-lg-4 px-0">
						<div class="form-group row">
							<?php if($isi['format_data'] == 'Softcopy') : ?>
							<!-- File -->
							<div class="col">
								<div class="custom-file">
									<input type="file" name="files[]" class="custom-file-input">
									<label class="custom-file-label" data-browse="Cari">Pilih file</label>
								</div>
								<small class="form-text px-2">Format .xls, .xlsx, .csv, .pdf, .rar, .zip</small>
							</div>
							<?php else : ?>
							<!-- Tanggal Pengambilan -->
							<div class="col">
								<div class="input-group kalender">
									<input type="text" name="tanggal_ambil[]" class="form-control docs-date" data-toggle="datepicker" autocomplete="off" placeholder="Tanggal Ambil Data" readonly>
									<div class="input-group-append">
										<a class="btn btn-outline-secondary reset-date px-2" data-toggle="tooltip" data-placement="bottom" title="Reset Tanggal">
											<i class="bi bi-x-circle" style="font-size:20px"></i>
										</a>
									</div>
								</div>
							</div>
							<?php endif ?>
						</div>
						
						<div class="form-group row">
							<div class="col">
								<textarea type="text" name="keterangan[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Keterangan"></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<hr class="my-0">
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" class="btn btn-primary mr-1">Kirim</button>
						<a href="<?=base_url() . $batal?>" class="btn btn-secondary mr-1">Batal</a>
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
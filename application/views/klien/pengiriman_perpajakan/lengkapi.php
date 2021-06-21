<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mb-3">
		<div class="col px-lg-4">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_pengiriman" value="<?=$id_pengiriman?>">
				
				<?php $num=0; foreach($isi as $i) : ?>
				<input type="hidden" name="format_data[]" value="<?=$i['format_data']?>">
				<div class="form-row pt-3 pb-2">
					<label class="col-form-label pt-0"><b><?= ++$num .'.' ?></b></label>
					
					<div class="col col-lg-5">
						<div class="form-row mb-2">
							<div class="col-4">Jenis Data</div>
							<div class="col">: <?=$i['jenis_data']?></div>
						</div>
						<div class="form-row mb-2">
							<div class="col-4">Detail</div>
							<div class="col">: <?=$i['detail']?></div>
						</div>
						<div class="form-row mb-2">
							<div class="col-4">Format Data</div>
							<div class="col">: <?=$i['format_data']?></div>
						</div>
						<div class="form-row mb-2">
							<div class="col-4">Status</div>
							<div class="col">: <?=$i['statusBadge']?></div>
						</div>
						<?php if($i['status'] == 2) : ?>
							<div class="form-row mb-2">
								<div class="col-4">Note</div>
								<div class="col">: <?=$i['note']?></div>
							</div>
						<?php endif ?>
					</div>
					
					<div class="col col-lg-4">
						<div class="form-group row">
							<?php if($i['format_data'] == 'Softcopy') : ?>
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
										<a class="btn btn-outline-secondary reset px-2" data-toggle="tooltip" data-placement="bottom" title="Reset Tanggal">
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
				<?php endforeach ?>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">Kirim</button>
						<a href="<?= base_url(); ?>klien/pengiriman_data_perpajakan" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/bs-custom-file-input.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/jquery.mask.min.js"></script>
<script>
	$(document).ready(function () {
		$('.docs-date').mask('00-00-0000');
		
		bsCustomFileInput.init();
		
		//memanggil date picker
		const myDatePicker = $('[data-toggle="datepicker"]').datepicker({
			autoHide	: true,
			format		: 'dd-mm-yyyy',
			startDate	: '<?= date('d-m-Y') ?>',
		});
		
		$(".reset").click(function() {
			$(this).closest('.kalender').find("input[type=text]").val("");
		});
		
		$('[data-toggle="tooltip"]').mouseenter(function() {
			$(this).tooltip();
		});
	})
</script>
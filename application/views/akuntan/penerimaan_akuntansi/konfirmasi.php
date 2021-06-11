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
						<?php if($format_data[$i] == 'Softcopy') : ?>
						<div class="form-row my-2">
							<div class="col-4">File</div>
							<div class="col">
								: <a href="<?=base_url() . $lokasi . $file[$i]?>"><?=$file[$i]?></a>
							</div>
						</div>
						<?php else : ?>
						<div class="form-row my-2">
							<div class="col-4">Tanggal Ambil</div>
							<div class="col">: <?=$file[$i]?></div>
						</div>
						<?php endif ?>
					</div>
					
					<?php 
						$lengkap	= ($status[$i] == 'lengkap') ? 'checked' : '';
						$kurang		= ($status[$i] == 'kurang') ? 'checked' : '';
						$belum		= ($status[$i] == 'belum') ? 'checked' : '';
					?>
					<div class="col col-lg-5">
						<div class="form-row">
							<label for="klien" class="col-form-label pr-3 py-0">Status :</label> 
							<div class="col-sm">
								<div class="form-check mb-2">
									<input class="form-check-input" type="radio" name="status[<?=$i?>]" id="lengkap[<?=$i?>]" value="lengkap" <?=$lengkap?>>
									<label class="form-check-label" for="lengkap[<?=$i?>]">Lengkap</label>
								</div>
								<div class="form-check mb-2">
									<input class="form-check-input" type="radio" name="status[<?=$i?>]" id="kurang[<?=$i?>]" value="kurang" <?=$kurang?>>
									<label class="form-check-label" for="kurang[<?=$i?>]">Kurang Lengkap</label>
								</div>
								<div class="form-check mb-2" style="display:none">
									<input class="form-check-input" type="radio" name="status[<?=$i?>]" id="belum[<?=$i?>]" value="belum" <?=$belum?>>
									<label class="form-check-label" for="belum[<?=$i?>]">Kosong</label>
								</div>
							</div>
						</div>
						
						<div class="form-row mt-2 mb-3">
							<div class="col">
								<textarea type="text" name="keterangan2[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Keterangan"></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<hr class="my-0">
				<?php endfor ?>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">Kirim</button>
						<button type="reset" name="reset" class="btn btn-outline-secondary mr-1">Reset</button>
						<a href="<?= base_url(); ?>akuntan/penerimaan_data_akuntansi" class="btn btn-secondary">
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
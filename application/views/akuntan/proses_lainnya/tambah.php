<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h2 class="mb-2"><?= $judul; ?></h2>
		</div>
	</div>
	
	<hr class="my-0">
	
	<div class="row row-child mt-3">
		<div class="col col-proses">
			<!-- Klien -->
			<div class="row mb-3">
				<div class="col col-sm-3">Klien</div> 
				<div class="col col-sm">: <?=$pengiriman['nama_klien']?></div>
			</div>
			
			<!-- Jenis Data -->
			<div class="row mb-3">
				<div class="col col-sm-3">Jenis Data</div> 
				<div class="col col-sm">: <?=$pengiriman['jenis_data']?></div>
			</div>
			
			<!-- Detail -->
			<div class="row mb-3">
				<div class="col col-sm-3">Detail</div> 
				<div class="col col-sm">: <?=$pengiriman['detail']?></div>
			</div>
			
			<!-- Output -->
			<div class="row mb-3">
				<div class="col col-sm-3">Output</div> 
				<div class="col col-sm">: <?=$pengiriman['nama_tugas']?></div>
			</div>
			
			<!-- Lama Pengerjaan -->
			<div class="row mb-3">
				<div class="col col-sm-3">Lama Pengerjaan</div> 
				<div class="col col-sm">: <?=$pengiriman['standar']?></div>
			</div>
			
			<!-- Isi Form -->
			<form action="" method="post"> 
				<input type="hidden" id="id_proses" name="id_proses" value="<?=$pengiriman['id_proses']?>">

				<!-- Mulai Proses -->
				<div class="form-group row kalender mt-4">
					<label for="tanggal_mulai" class="col-sm-3 col-form-label">Mulai Proses</label> 
					<div class="col-sm pr-0">
						<div class="input-group">
							<input type="text" name="tanggal_mulai" class="form-control date" id="tanggal_mulai" placeholder="Tanggal Mulai" autocomplete="off" value="<?=set_value('tanggal_mulai')?>" readonly required>
							<div class="input-group-append">
								<a class="btn btn-outline-secondary reset-date px-2" data-toggle="tooltip" data-placement="bottom" title="Reset Tanggal">
									<i class="bi bi-x-circle" style="font-size:20px"></i>
								</a>
							</div>
						</div>
						<small class="form-text text-danger"><?= form_error('tanggal_mulai', '<p class="mb-0">', '</p>') ?></small>
					</div>
					<div class="col-sm">
						<input type="text" name="jam_mulai" class="form-control timepicker" id="jam_mulai" placeholder="Jam Mulai" autocomplete="off" value="<?=set_value('jam_mulai')?>" readonly required>
						<small class="form-text text-danger"><?= form_error('jam_mulai', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Selesai Proses -->
				<div class="form-group row kalender">
					<label for="tanggal_selesai" class="col-sm-3 col-form-label">Selesai Proses</label> 
					<div class="col-sm pr-0">
						<div class="input-group">
							<input type="text" name="tanggal_selesai" class="form-control date" id="tanggal_selesai" placeholder="Tanggal Selesai" autocomplete="off" value="<?=set_value('tanggal_selesai')?>" readonly>
							<div class="input-group-append">
								<a class="btn btn-outline-secondary reset-date px-2" data-toggle="tooltip" data-placement="bottom" title="Reset Tanggal">
									<i class="bi bi-x-circle" style="font-size:20px"></i>
								</a>
							</div>
						</div>
						<small class="form-text text-danger"><?= form_error('tanggal_selesai', '<p class="mb-0">', '</p>') ?></small>
					</div>
					<div class="col-sm">
						<input type="text" name="jam_selesai" class="form-control timepicker" id="jam_selesai" placeholder="Jam Selesai" autocomplete="off" readonly>
						<small class="form-text text-danger"><?= form_error('jam_selesai', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Keterangan -->
				<div class="form-group row">
					<label for="keterangan3" class="col-sm-3 col-form-label">Keterangan</label> 
					<div class="col-sm">
						<input type="text" name="keterangan3" class="form-control" id="keterangan3" value="<?= set_value('keterangan3') ?>">
					</div>
				</div>

				<!-- Tombol Simpan -->
				<div class="row my-3 text-right">
					<div class="col p-0">
						<input class="btn btn-primary" type="submit" value="Mulai">
						<a href="javascript:history.go(-1)" class="btn btn-secondary mr-3">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/mdtimepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>

<script>
	//memanggil time picker
	mdtimepicker('.timepicker', {
		is24hour	: true,
		clearBtn	: true,
	});

	//memanggil datepicker
	$(function() {
		var startDate	= $('#tanggal_mulai');
		var endDate		= $('#tanggal_selesai');
		
		startDate.datepicker({
			autoHide	: true,
			format		: 'dd/mm/yyyy',
		});
		endDate.datepicker({
			autoHide	: true,
			format		: 'dd/mm/yyyy',
			startDate	: startDate.datepicker('getDate'),
		});
		
		startDate.on('change', function () {
			endDate.datepicker('setStartDate', startDate.datepicker('getDate'));
		});
	});
	
	$(".reset-date").click(function() {
		$(this).closest('.kalender').find('.date').datepicker('reset');
	});
</script>

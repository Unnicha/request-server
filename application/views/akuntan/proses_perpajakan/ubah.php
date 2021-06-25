<div class="container-fluid">
	<!-- Judul Form -->
	<div class="row row-child">
		<div class="col">
			<h2 class="mb-2"><?= $judul; ?></h2>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mt-3">
		<div class="col col-proses">
			<!-- Isi Form -->
			<form action="" method="post"> 
				<input type="hidden" id="id_proses" name="id_proses" value="<?=$pengiriman['id_proses']?>">

				<!-- Klien -->
				<div class="form-group row">
					<label for="id_klien" class="col-sm-3 col-form-label">Klien</label> 
					<div class="col-sm">
						<input type="text" name="nama_klien" class="form-control" id="nama_klien" value="<?=$pengiriman['nama_klien']?>" readonly>
					</div>
				</div>

				<!-- Jenis Data -->
				<div class="form-group row">
					<label for="jenis_data" class="col-sm-3 col-form-label">Jenis Data</label> 
					<div class="col-sm">
						<input type="text" name="jenis_data" class="form-control" id="jenis_data" value="<?=$pengiriman['jenis_data']?>" readonly>
					</div>
				</div>

				<!-- Detail -->
				<div class="form-group row">
					<label for="detail" class="col-sm-3 col-form-label">Detail</label> 
					<div class="col-sm">
						<input type="text" name="detail" class="form-control" id="detail" value="<?=$pengiriman['detail']?>" readonly>
					</div>
				</div>

				<!-- Output -->
				<div class="form-group row">
					<label for="nama_tugas" class="col-sm-3 col-form-label">Output</label> 
					<div class="col-sm">
						<input type="text" name="nama_tugas" class="form-control" id="nama_tugas" value="<?=$pengiriman['nama_tugas']?>" readonly>
					</div>
				</div>
				
				<!-- Mulai Proses -->
				<div class="form-group row">
					<label for="tanggal_mulai" class="col-sm-3 col-form-label"> Mulai Proses </label> 
					<div class="col-sm pr-0">
						<input type="text" name="tanggal_mulai" class="form-control" id="tanggal_mulai" value="<?=$mulai[0]?>" readonly>
					</div>
					<div class="col-sm">
						<input type="text" name="jam_mulai" class="form-control" id="jam_mulai" value="<?=$mulai[1]?>" readonly>
					</div>
				</div>

				<!-- Selesai Proses -->
				<div class="form-group row kalender">
					<label for="tanggal_selesai" class="col-sm-3 col-form-label"> Selesai Proses </label> 
					<div class="col-sm pr-0">
						<div class="input-group">
							<input type="text" name="tanggal_selesai" class="form-control date" id="tanggal_selesai" placeholder="Tanggal Selesai" autocomplete="off" required readonly>
							<div class="input-group-append">
								<a class="btn btn-outline-secondary reset-date px-2" data-toggle="tooltip" data-placement="bottom" title="Reset Tanggal">
									<i class="bi bi-x-circle" style="font-size:20px"></i>
								</a>
							</div>
						</div>
						<small class="form-text text-danger"><?= form_error('tanggal_selesai', '<p class="mb-0">', '</p>') ?></small>
					</div>
					<div class="col-sm">
						<input type="text" name="jam_selesai" class="form-control timepicker" id="jam_selesai" placeholder="Jam Selesai" autocomplete="off" required readonly>
						<small class="form-text text-danger"><?= form_error('jam_selesai', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Keterangan -->
				<div class="form-group row">
					<label for="keterangan3" class="col-sm-3 col-form-label">Keterangan</label> 
					<div class="col-sm">
						<textarea name="keterangan3" class="form-control" id="keterangan3" style="height:calc(1.5em + .75rem + 2px)"><?= $pengiriman['ket_proses'] ?></textarea>
					</div>
				</div>

				<!-- Tombol Simpan -->
				<div class="row my-3 text-right">
					<div class="col p-0">
						<input class="btn btn-primary" type="submit" value="Selesai">
						<a href="<?= base_url(); ?>akuntan/proses_data_perpajakan" class="btn btn-secondary mr-3">Batal</a>
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
		var startDate	= $('#tanggal_mulai').val();
		var endDate		= $('#tanggal_selesai');
		
		endDate.datepicker({
			autoHide	: true,
			format		: 'dd/mm/yyyy',
			startDate	: startDate,
		});
	});
	
	$(".reset-date").click(function() {
		$(this).closest('.kalender').find('.date').datepicker('reset');
	});
</script>

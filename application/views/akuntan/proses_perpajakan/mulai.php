<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h4><?= $judul ?></h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-round mb-4">
				<div class="card-body">
					<h5 class="card-title">Detail Data</h5>
					
					<table class="table table-detail mb-0">
						<div class="tbody">
							<tr>
								<td>Nama Klien</td>
								<td><?=$pengiriman['nama_klien']?></td>
							</tr>
							<tr>
								<td>Jenis Data</td>
								<td><?=$pengiriman['jenis_data']?></td>
							</tr>
							<tr>
								<td>Detail</td>
								<td><?=$pengiriman['detail']?></td>
							</tr>
							<tr>
								<td>Output</td>
								<td>
									<?=$pengiriman['nama_tugas']?>
									<small class="form-text text-danger"><?= form_error('nama_tugas', '<p class="mb-0">', '<br>Harap hubungi Admin.</p>') ?></small>
								</td>
							</tr>
							<tr>
								<td>Estimasi</td>
								<td><?=$pengiriman['standar']?></td>
							</tr>
						</div>
					</table>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="card card-round mb-4">
				<div class="card-body px-4">
					<h5 class="card-title mb-3">Proses Data</h5>
					
					<form action="" method="post">
						<input type="hidden" name="id_data" value="<?=$pengiriman['id_data']?>">
						<input type="hidden" name="id_user" value="<?=$this->session->userdata('id_user')?>">
						<input type="hidden" name="nama_tugas" value="<?=$pengiriman['nama_tugas']?>">
						
						<!-- Mulai Proses -->
						<div class="form-row mb-3 kalender">
							<label class="col-lg-3 col-form-label">Mulai Proses</label>
							<div class="col-sm-6 col-lg">
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
							<div class="col-sm-6 col-lg">
								<input type="text" name="jam_mulai" class="form-control timepicker" id="jam_mulai" placeholder="Jam Mulai" autocomplete="off" value="<?=set_value('jam_mulai')?>" readonly required>
								<small class="form-text text-danger"><?= form_error('jam_mulai', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
			
						<!-- Selesai Proses -->
						<div class="form-row mb-3 kalender">
							<label class="col-lg-3 col-form-label">Selesai Proses</label> 
							<div class="col-sm-6 col-lg">
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
							<div class="col-sm-6 col-lg">
								<input type="text" name="jam_selesai" class="form-control timepicker" id="jam_selesai" placeholder="Jam Selesai" autocomplete="off" readonly>
								<small class="form-text text-danger"><?= form_error('jam_selesai', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Keterangan -->
						<div class="form-row mb-3">
							<label class="col-lg-3 col-form-label">Keterangan</label> 
							<div class="col-lg">
								<input type="text" name="keterangan3" class="form-control" id="keterangan" value="<?= set_value('keterangan') ?>">
							</div>
						</div>
						
						<!-- Tombol Simpan -->
						<div class="row text-right">
							<div class="col">
								<button type="submit" class="btn btn-primary">Simpan</button>
								<a href="<?=base_url()?>akuntan/proses_data_perpajakan" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<a href="<?=base_url()?>akuntan/proses_data_perpajakan" class="btn btn-secondary">Kembali</a>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/mdtimepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>

<script>
	$('[data-toggle="tooltip"]').on('mouseover', function() {
		$(this).tooltip();
	})
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

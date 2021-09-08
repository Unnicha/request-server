<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-4">
			<div class="card border-0">
				<div class="card-body px-4">
					<h5 class="px-2 mb-3">Overview</h5>
					
					<table class="table table-detail">
						<tbody>
							<tr>
								<td class="detail-title">Nama Klien</td>
								<td><?=$proses['nama_klien']?></td>
							</tr>
							<tr>
								<td class="detail-title">Jenis Data</td>
								<td><?=$proses['jenis_data']?></td>
							</tr>
							<tr>
								<td class="detail-title">Detail</td>
								<td><?=$proses['detail']?></td>
							</tr>
							<tr>
								<td class="detail-title">Output</td>
								<td><?=$proses['nama_tugas']?></td>
							</tr>
							<tr>
								<td class="detail-title">Durasi</td>
								<td><?=$proses['durasi']?></td>
							</tr>
							<tr>
								<td class="detail-title">Estimasi</td>
								<td><?=$proses['standar']?></td>
							</tr>
							<tr>
								<td class="detail-title">Pengiriman Terakhir</td>
								<td><?=$proses['last']?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row mt-3">
				<div class="col">
					<a href="<?=base_url()?>akuntan/proses_data_perpajakan" class="btn btn-secondary">Kembali</a>
				</div>
			</div>
		</div>
		
		<div class="col-lg">
			<div class="card card-round card-shadow mt-3 mt-lg-0">
				<div class="card-body px-4">
					<h5>Detail Proses</h5>
					
					<div class="row mt-3">
						<div class="col">
							<form action="" method="post">
								<input type="hidden" id="id_proses" name="id_proses" value="<?=$proses['id_proses']?>">
								<input type="hidden" id="id_data" name="id_data" value="<?=$proses['id_data']?>">
								
								<!-- Mulai Proses -->
								<div class="form-row mb-3">
									<label class="col-lg-3 col-form-label">Mulai Proses</label> 
									<div class="col-md-6 col-lg">
										<input type="text" name="tanggal_mulai" class="form-control" id="tanggal_mulai" value="<?=$mulai[0]?>" readonly>
										<small class="form-text text-danger"><?= form_error('tanggal_mulai', '<p class="mb-0">', '</p>') ?></small>
									</div>
									<div class="col-md-6 col-lg">
										<input type="text" name="jam_mulai" class="form-control" id="jam_mulai" value="<?=$mulai[1]?>" readonly>
										<small class="form-text text-danger"><?= form_error('jam_mulai', '<p class="mb-0">', '</p>') ?></small>
									</div>
								</div>
				
								<!-- Selesai Proses -->
								<div class="form-row mb-3 kalender">
									<label class="col-lg-3 col-form-label">Selesai Proses</label> 
									<div class="col-md-6 col-lg">
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
									<div class="col-md-6 col-lg">
										<input type="text" name="jam_selesai" class="form-control timepicker" id="jam_selesai" placeholder="Jam Selesai" autocomplete="off" required readonly>
										<small class="form-text text-danger"><?= form_error('jam_selesai', '<p class="mb-0">', '</p>') ?></small>
									</div>
								</div>
				
								<!-- Keterangan -->
								<div class="form-row mb-3">
									<label class="col-lg-3 col-form-label">Keterangan</label> 
									<div class="col">
										<textarea name="keterangan3" class="form-control" id="keterangan" style="height:calc(1.5em + .75rem + 2px)"><?= $proses['ket_proses'] ?></textarea>
									</div>
								</div>
				
								<!-- Tombol Simpan -->
								<div class="row text-right">
									<div class="col">
										<button type="submit" class="btn btn-primary">Simpan</button>
										<a href="<?=base_url()?>akuntan/proses_data_perpajakan" class="btn btn-light">Batal</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
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

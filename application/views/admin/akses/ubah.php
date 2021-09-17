<div class="content container-fluid">
	<div class="card card-round">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="row mb-4 text-center">
						<div class="col">
							<h3><?=$judul?></h3>
						</div>
					</div>
					
					<form action="" method="post">
						<input type="hidden" id="id_akses" name="id_akses" value="<?=$akses['id_akses']?>">
						<input type="hidden" id="id_klien" name="id_klien" value="<?=$akses['id_klien']?>">
						<input type="hidden" id="masa" name="masa" value="<?=$akses['masa']?>">
						
						<!-- Klien -->
						<div class="form-group row">
							<label class="col-sm-4 col-md-3 col-form-label">Nama Klien</label>
							<div class="col-sm">
								<input type="text" class="form-control" name="nama" value="<?=$akses['nama_klien']?>" readonly>
							</div>
						</div>
						
						<!-- Tahun -->
						<div class="form-group row">
							<label class="col-sm-4 col-md-3 col-form-label">Tahun Akses</label>
							<div class="col-sm">
								<input type="text" class="form-control" name="tahun" value="<?=$akses['tahun']?>" readonly>
							</div>
						</div>
		
						<!-- Masa -->
						<div class="form-group row">
							<label class="col-sm-4 col-md-3 col-form-label">Bulan Mulai</label>
							<div class="col-sm">
								<input type="text" class="form-control" name="bulan" value="<?=$bulan?>" readonly>
							</div>
						</div>
						
						<!-- Akses -->
						<div class="form-group row">
							<label class="col col-form-label">
								<b>Penanggung jawab</b>
							</label>
						</div>
		
						<!-- Data Akuntansi -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">PJ Akuntansi</label>
							<div class="col-sm">
								<select name='akuntansi[]' class="form-control select-multiple" multiple="multiple" required>
									<?php 
										$data1 = explode(',', $akses['akuntansi']);
										foreach ($akuntan as $k) :
											$pilih = (in_array($k['id_user'], $data1)) ? 'selected="selected"' : '';
										?>
									<option value="<?= $k['id_user'] ?>" <?=$pilih?>><?= $k['nama'] ?></option>
									<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('akuntansi[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Data Perpajakan -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">PJ Perpajakan</label>
							<div class="col-sm">
								<select name='perpajakan[]' class="form-control select-multiple" multiple="multiple" required>
									<?php
										$data2 = explode(',', $akses['perpajakan']);
										foreach ($akuntan as $k) :
											$pilih = (in_array($k['id_user'], $data2)) ? 'selected="selected"' : '';
										?>
									<option value="<?= $k['id_user'] ?>" <?=$pilih?>><?= $k['nama'] ?></option>
									<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('perpajakan[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Data Lainnya -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">PJ Lainnya</label>
							<div class="col-sm">
								<select name='lainnya[]' class="form-control select-multiple" multiple="multiple" required>
									<?php
										$data3 = explode(',', $akses['lainnya']);
										foreach ($akuntan as $k) :
											$pilih = (in_array($k['id_user'], $data3)) ? 'selected="selected"' : '';
										?>
									<option value="<?= $k['id_user'] ?>" <?=$pilih?>><?= $k['nama'] ?></option>
									<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('lainnya[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<div class="row mt-4 text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary"> Batal </a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('.select-multiple').select2({
			placeholder: '--Tambahkan Akuntan--',
			tags: true,
		});
	});
</script>

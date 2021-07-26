<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
	</div>

	<hr class="my-0">

	<!-- Isi Form -->
	<form action="" method="post">
		<div class="row row-child">
			<div class="col col-tambah">
				<input type="hidden" id="id_akses" name="id_akses" value="<?=$akses['id_akses']?>">
				<input type="hidden" id="id_akuntan" name="id_akuntan" value="<?=$akses['id_akuntan']?>">
				<input type="hidden" id="masa" name="masa" value="<?=$akses['masa']?>">
				
				<!-- Tahun -->
				<div class="form-group row mt-3">
					<label class="col-sm-4 col-form-label">Tahun Akses</label>
					<div class="col-sm">
						<input type="text" class="form-control" name="tahun" value="<?=$akses['tahun']?>" readonly>
					</div>
				</div>

				<!-- Masa -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Bulan Mulai</label>
					<div class="col-sm">
						<input type="text" class="form-control" name="bulan" value="<?=$bulan?>" readonly>
					</div>
				</div>
				
				<!-- Akuntan -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Nama Akuntan</label>
					<div class="col-sm">
						<input type="text" class="form-control" name="nama" value="<?=$akses['nama']?>" readonly>
					</div>
				</div>
				
				<!-- Akses -->
				<div class="form-group row">
					<label for="akuntansi" class="col-sm-4 col-form-label">
						<b>Akses Data Klien</b>
					</label>
				</div>

				<!-- Data Akuntansi -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Data Akuntansi</label>
					<div class="col-sm">
						<select name='akuntansi[]' class="form-control select-multiple" multiple="multiple" required>
							<?php 
								$data1 = explode(',', $akses['akuntansi']);
								foreach ($klien as $k) :
									if(in_array($k['id_klien'], $data1)) {
										$pilih = 'selected="selected"';
									} else {
										$pilih = '';
									} ?>
							<option value="<?= $k['id_klien'] ?>" <?=$pilih?>><?= $k['nama_klien'] ?></option>
							<?php endforeach ?>
						</select>
						<small class="form-text text-danger"><?= form_error('akuntansi[]', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Data Perpajakan -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Data Perpajakan</label>
					<div class="col-sm">
						<select name='perpajakan[]' class="form-control select-multiple" multiple="multiple" required>
							<?php
								$data2 = explode(',', $akses['perpajakan']);
								foreach ($klien as $k) :
									if(in_array($k['id_klien'], $data2)) {
										$pilih = 'selected="selected"';
									} else {
										$pilih = '';
									} ?>
							<option value="<?= $k['id_klien'] ?>" <?=$pilih?>><?= $k['nama_klien'] ?></option>
							<?php endforeach ?>
						</select>
						<small class="form-text text-danger"><?= form_error('perpajakan[]', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Data Lainnya -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Data Lainnya</label>
					<div class="col-sm">
						<select name='lainnya[]' class="form-control select-multiple" multiple="multiple" required>
							<?php
								$data3 = explode(',', $akses['lainnya']);
								foreach ($klien as $k) :
									if(in_array($k['id_klien'], $data3)) {
										$pilih = 'selected="selected"';
									} else {
										$pilih = '';
									} ?>
							<option value="<?= $k['id_klien'] ?>" <?=$pilih?>><?= $k['nama_klien'] ?></option>
							<?php endforeach ?>
						</select>
						<small class="form-text text-danger"><?= form_error('lainnya[]', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<div class="row mt-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
						<a href="javascript:history.go(-1)" class="btn btn-secondary"> Batal </a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('.select-multiple').select2({
			placeholder: '--Tambahkan Klien--',
			tags: true,
		});
	});
</script>

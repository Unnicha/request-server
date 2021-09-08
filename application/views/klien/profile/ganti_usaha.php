<div class="content container-fluid">
	<h3 class="mb-3"><?=$judul?></h3>
	
	<div class="card card-round card-shadow">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<form action="" method="post">
						<input type="hidden" name="tipe" value="<?=$tipe?>">
						<input type="hidden" name="table" value="<?=$table?>">
						<input type="hidden" name="id_klien" value="<?=$klien['id_klien']?>">
						
						<!-- Nama Usaha -->
						<div class="form-group row">
							<label for="nama_usaha" class="col-lg-3 col-form-label">Nama Usaha</label>
							<div class="col-lg">
								<input type="text" name="nama_usaha" class="form-control" id="nama_usaha" value="<?= $klien['nama_usaha'] ?>" required autofocus>
								<small class="form-text text-danger"><?= form_error('nama_usaha', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Kode KLU -->
						<div class="form-group row">
							<label for="kode_klu" class="col-lg-3 col-form-label">Kode KLU</label>
							<div class="col col-lg">
								<div class="input-group">
									<select name='kode_klu' class="selectpicker form-control" data-live-search="true" id="kode_klu" required>
										<option value="">-- Pilih Kode KLU --</option>
										<?php 
											foreach ($klu as $k) : 
												if($k['kode_klu'] == $klien['kode_klu']) {
													$pilih = "selected";
												} else {
													$pilih = "";
												} ?>
										<option value="<?= $k['kode_klu'] ?>" <?=$pilih;?>>
											<?= $k['kode_klu'] ?>| <?=$k['bentuk_usaha']?>- <?=$k['jenis_usaha']?>
										</option>
										<?php endforeach ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('kode_klu', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Bentuk Usaha -->
						<div class="form-group row">
							<label for="bentuk_usaha" class="col-lg-3 col-form-label">Bentuk Usaha</label>
							<div class="col col-lg">
								<input type="text" name="bentuk_usaha" class="form-control" id="bentuk_usaha" value="<?= $klien['bentuk_usaha'] ?>" readonly>
							</div>
						</div>
					
						<!-- Jenis Usaha -->
						<div class="form-group row">
							<label for="jenis_usaha" class="col-lg-3 col-form-label">Jenis Usaha</label>
							<div class="col col-lg">
								<input type="text" name="jenis_usaha" class="form-control" id="jenis_usaha" value="<?= $klien['jenis_usaha'] ?>" readonly>
							</div>
						</div>
						
						<!-- No. Akte Terakhir -->
						<div class="form-group row">
							<label for="no_akte" class="col-lg-3 col-form-label">Nomor Akte</label>
							<div class="col-lg">
								<input type="text" name="no_akte" class="form-control" id="no_akte" value="<?= $klien['no_akte'] ?>" required>
								<small class="form-text text-danger"><?= form_error('no_akte', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Alamat -->
						<div class="form-group row">
							<label for="alamat" class="col-lg-3 col-form-label">Alamat</label>
							<div class="col-lg">
								<textarea name="alamat" class="form-control" id="alamat" style="height:90px" required><?= $klien['alamat'] ?></textarea>
								<small class="form-text text-danger"><?= form_error('alamat', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- No. Telepon -->
						<div class="form-group row">
							<label for="telp" class="col-lg-3 col-form-label">Nomor Telepon</label>
							<div class="col col-lg">
								<input type="text" name="telp" class="form-control" id="telp" value="<?= $klien['telp'] ?>" required>
								<small class="form-text text-danger"><?= form_error('telp', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Email -->
						<div class="form-group row">
							<label for="email" class="col-lg-3 col-form-label">Email</label>
							<div class="col col-lg">
								<input type="text" name="email" class="form-control" id="email" value="<?= $klien['email_klien'] ?>" required>
								<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- No. HP -->
						<div class="form-group row">
							<label for="no_hp" class="col-lg-3 col-form-label">No. HP </label>
							<div class="col col-lg">
								<input type="text" name="no_hp" class="form-control" id="no_hp" value="<?= $klien['no_hp'] ?>">
								<small class="form-text text-danger"><?= form_error('no_hp', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Status Pekerjaan -->
						<div class="form-group row">
							<label for="status_pekerjaan" class="col-lg-3 col-form-label">Status Pekerjaan</label>
							<div class="col col-lg">
								<div class="input-group">
									<select name='status_pekerjaan' class="form-control" data-live-search="true" id="status_pekerjaan" required>
										<option value="">-- Pilih Status Pekerjaan --</option>
										<?php 
											foreach($status as $stat) :
												if($stat == $klien['status_pekerjaan'])
												$pilih = 'selected';
												else
												$pilih = '';
										?>
										<option value="<?=$stat?>" <?=$pilih?>><?=$stat?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('status_pekerjaan', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Perbarui</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script>
	$(document).on('change', '#kode_klu', function() {
		var kode = $(this).find(':selected').val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url(); ?>admin/master/klien/pilih_klu',
			data: 'action='+ kode,
			success: function(data) {
				var json = data,
				obj = JSON.parse(json);
				$('#bentuk_usaha').val(obj.bentuk_usaha);
				$('#jenis_usaha').val(obj.jenis_usaha);
			}
		})
	});
</script>
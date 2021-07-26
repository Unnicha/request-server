<div class="container-fluid">
	<!-- Judul Form -->
	<div class="row" tabindex="-1">
		<div class="col">
			<h2 class="text-center"><?= $judul ?></h2>
		</div>
	</div>
	
	<hr class="my-0">
	
	<!-- Isi Form -->
	<form action="" method="post">  
		<input type="hidden" name="level" id="level" value="<?=$level?>">

		<div class="row row-child mt-3">
			<div class="col">
				<div class="row">
					<div class="col">
						<h6>Info Akun</h6>
					</div>
				</div>
				
				<div class="row row-child mt-2">
					<div class="col-sm-12 col-lg-6">
						<!-- Nama Klien -->
						<div class="form-group row">
							<label for="nama_klien" class="col-sm-4 col-form-label">Nama Klien</label> 
							<div class="col-sm">
								<input type="text" name="nama_klien" class="form-control" id="nama_klien" value="<?= set_value('nama_klien') ?>" required autofocus>
								<small class="form-text text-danger">
									<?= form_error('nama_klien', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
						
						<!-- Username -->
						<div class="form-group row">
							<label for="username" class="col-sm-4 col-form-label">Username</label>
							<div class="col-sm">
								<input type="text" name="username" class="form-control" id="username" value="<?= set_value('username') ?>" required>
								<small class="form-text text-danger">
									<?= form_error('username', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
					</div>
					
					<div class="col-sm-12 col-lg-6">
						<!-- Password -->
						<div class="form-group row">
							<label for="password" class="col-sm-4 col-form-label">Password</label> 
							<div class="col-sm">
								<input type="password" name="password" class="form-control" id="password" value="<?= set_value('password') ?>" required>
								<small class="form-text text-danger">
									<?= form_error('password', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
						
						<!-- Konfirmasi Password -->
						<div class="form-group row">
							<label for="passconf" class="col-sm-4 col-form-label">Konfirmasi</label> 
							<div class="col-sm">
								<input type="password" name="passconf" class="form-control" id="passconf" value="<?= set_value('passconf') ?>" required>
								<small class="form-text text-danger">
									<?= form_error('passconf', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
					</div>
				</div>
				
				<hr class="my-0">
				
				<div class="row mt-3">
					<div class="col">
						<h6>Info Perusahaan</h6>
					</div>
				</div>
				
				<div class="row row-child mt-2">
					<div class="col-sm-12 col-lg-6">
						<!-- Nama Usaha -->
						<div class="form-group row">
							<label for="nama_usaha" class="col-sm-4 col-form-label">Nama Usaha</label>
							<div class="col col-sm">
								<input type="text" name="nama_usaha" class="form-control" id="nama_usaha" value="<?= set_value('nama_usaha') ?>" required>
								<small class="form-text text-danger">
								<?= form_error('nama_usaha', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
						
						<!-- Alamat -->
						<div class="form-group row">
							<label for="alamat" class="col-sm-4 col-form-label">Alamat</label> 
							<div class="col-sm">
								<textarea name="alamat" class="form-control" id="alamat" value="<?= set_value('alamat') ?>" required></textarea>
								<small class="form-text text-danger">
								<?= form_error('alamat', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
				
						<!-- No. Telepon -->
						<div class="form-group row">
							<label for="telp" class="col-sm-4 col-form-label">Nomor Telepon</label> 
							<div class="col col-sm">
								<input type="text" name="telp" class="form-control" id="telp" value="<?= set_value('telp') ?>" required>
								<small class="form-text text-danger">
								<?= form_error('telp', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
						
						<!-- No. HP -->
						<div class="form-group row">
							<label for="no_hp" class="col-sm-4 col-form-label">No. HP</label>
							<div class="col col-sm">
								<input type="text" name="no_hp" class="form-control" id="no_hp" value="<?= set_value('no_hp') ?>">
								<small class="form-text text-danger">
								<?= form_error('no_hp', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
						
						<!-- Email -->
						<div class="form-group row">
							<label for="email" class="col-sm-4 col-form-label">Email</label>
							<div class="col col-sm">
								<input type="text" name="email" class="form-control" id="email" value="<?= set_value('email') ?>" required>
								<small class="form-text text-danger">
								<?= form_error('email', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
					</div>
					
					<div class="col-sm-12 col-lg-6">
						<!-- Kode KLU -->
						<div class="form-group row">
							<label for="kode_klu" class="col-sm-4 col-form-label">Kode KLU</label>
							<div class="col col-sm">
								<div class="input-group">
									<select name='kode_klu' class="selectpicker form-control" data-size="6" data-live-search="true" id="kode_klu" required>
										<option value="">-- Pilih Kode KLU --</option>
										<?php
											foreach ($klu as $k) : 
												if($k['kode_klu'] == set_value('kode_klu')) {
													$pilih = "selected";
												} else {
													$pilih = "";
												} ?>
										<option value="<?= $k['kode_klu'] ?>" <?=$pilih;?>>
											<?= $k['kode_klu'] ?> - <?=$k['bentuk_usaha']?> - <?=$k['jenis_usaha']?>
										</option>
										<?php endforeach ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('kode_klu', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Bentuk Usaha -->
						<div class="form-group row">
							<label for="bentuk_usaha" class="col-sm-4 col-form-label">Bentuk Usaha</label>
							<div class="col col-sm">
								<input type="text" name="bentuk_usaha" class="form-control" id="bentuk_usaha" value="<?= set_value('bentuk_usaha') ?>" readonly>
							</div>
						</div>
				
						<!-- Jenis Usaha -->
						<div class="form-group row">
							<label for="jenis_usaha" class="col-sm-4 col-form-label">Jenis Usaha</label>
							<div class="col col-sm">
								<input type="text" name="jenis_usaha" class="form-control" id="jenis_usaha" value="<?= set_value('jenis_usaha') ?>" readonly>
							</div>
						</div>
				
						<!-- No. Akte Terakhir -->
						<div class="form-group row">
							<label for="no_akte" class="col-sm-4 col-form-label">Nomor Akte</label> 
							<div class="col-sm">
								<input type="text" name="no_akte" class="form-control" id="no_akte" value="<?= set_value('no_akte') ?>" required>
								<small class="form-text text-danger">
								<?= form_error('no_akte', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
				
						<!-- Status Pekerjaan -->
						<div class="form-group row">
							<label for="status_pekerjaan" class="col-sm-4 col-form-label">Status Pekerjaan</label>
							<div class="col col-sm">
								<div class="input-group">
									<select name='status_pekerjaan' class="form-control" data-live-search="true" id="status_pekerjaan" required>
										<option value="">-- Pilih Status Pekerjaan --</option>
										<?php foreach($status_pekerjaan as $stat) : ?>
										<option value="<?=$stat?>"><?=$stat?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<small class="form-text text-danger">
								<?= form_error('status_pekerjaan', '<p class="mb-0">', '</p>') ?>
								</small>
							</div>
						</div>
					</div>
				</div>
				
				<hr class="my-0">
				
				<div class="row">
					<div class="col-sm-12 col-lg-6">
						<div class="row mt-3">
							<div class="col">
								<h6>Pimpinan</h6>
							</div>
						</div>
				
						<div class="row row-child mt-2">
							<div class="col">
								<!-- Nama Pimpinan -->
								<div class="form-group row">
									<label for="nama_pimpinan" class="col-sm-4 col-form-label">Nama</label>
									<div class="col-sm">
										<input type="text" name="nama_pimpinan" class="form-control" id="nama_pimpinan" value="<?= set_value('nama_pimpinan') ?>" required>
										<small class="form-text text-danger">
										<?= form_error('nama_pimpinan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- Jabatan -->
								<div class="form-group row">
									<label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label>
									<div class="col-sm">
										<input type="text" name="jabatan" class="form-control" id="jabatan" value="<?= set_value('jabatan') ?>" required>
										<small class="form-text text-danger">
										<?= form_error('jabatan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>

								<!-- No. HP Pimpinan -->
								<div class="form-group row">
									<label for="no_hp_pimpinan" class="col-sm-4 col-form-label">Nomor HP</label>
									<div class="col-sm">
										<input type="text" name="no_hp_pimpinan" class="form-control" id="no_hp_pimpinan" value="<?= set_value('no_hp_pimpinan') ?>" required>
										<small class="form-text text-danger">
										<?= form_error('no_hp_pimpinan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- Email Pimpinan -->
								<div class="form-group row">
									<label for="email_pimpinan" class="col-sm-4 col-form-label">Email</label>
									<div class="col-sm">
										<input type="text" name="email_pimpinan" class="form-control" id="email_pimpinan" value="<?= set_value('email_pimpinan') ?>">
										<small class="form-text text-danger">
										<?= form_error('email_pimpinan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="col-sm-12 col-lg-6">
						<div class="row mt-3">
							<div class="col">
								<h6>Counterpart</h6>
							</div>
						</div>
						
						<div class="row row-child mt-2">
							<div class="col">
								
								<!-- Nama Counterpart -->
								<div class="form-group row">
									<label for="nama_counterpart" class="col-sm-4 col-form-label">Nama</label> 
									<div class="col-sm">
										<input type="text" name="nama_counterpart" class="form-control" id="nama_counterpart" value="<?= set_value('nama_counterpart') ?>">
										<small class="form-text text-danger">
										<?= form_error('nama_counterpart', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- No. HP Counterpart -->
								<div class="form-group row">
									<label for="no_hp_counterpart" class="col-sm-4 col-form-label">Nomor HP</label>
									<div class="col-sm">
										<input type="text" name="no_hp_counterpart" class="form-control" id="no_hp_counterpart" value="<?= set_value('no_hp_counterpart') ?>">
										<small class="form-text text-danger">
										<?= form_error('no_hp_counterpart', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- Email Counterpart -->
								<div class="form-group row">
									<label for="email_counterpart" class="col-sm-4 col-form-label">Email</label>
									<div class="col-sm">
										<input type="text" name="email_counterpart" class="form-control" id="email_counterpart" value="<?= set_value('email_counterpart') ?>">
										<small class="form-text text-danger">
										<?= form_error('email_counterpart', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row float-right mr-3 mt-3 mb-5">
					<button type="submit" name="tambah" class="btn btn-primary mr-2">Simpan</button>
					<a href="javascript:history.go(-1)" name="tambah" class="btn btn-secondary">Batal</a>
				</div>
			</div>
		</div>
	</form>
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
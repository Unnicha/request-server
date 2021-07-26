<div class="container-fluid">
	<div class="row">
		<div class="col">
			<h3 class="px-3"><?=$judul?></h3>
		</div>
	</div>
	
	<hr class="my-0">
	
	<div class="row mt-3">
		<div class="col col-profile">
			<form action="" method="post">
				<input type="hidden" name="id_user" id="id_user" value="<?= $admin['id_user'] ?>">
				
				<!-- Password -->
				<div class="form-group row">
					<div class="col">
						<label for="password" class="form-label">Masukkan Password Baru</label> 
						<input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
						<small class="form-text text-danger"><?= form_error('password', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<!-- Konfirmasi -->
				<div class="form-group row">
					<div class="col">
						<label for="passconf" class="form-label">Konfirmasi Password</label> 
						<input type="password" name="passconf" class="form-control" id="passconf" placeholder="Password" required>
						<small class="form-text text-danger"><?= form_error('passconf', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<div class="row mt-4">
					<div class="col">
						<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
						<a href="<?= base_url(); ?>admin/profile" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

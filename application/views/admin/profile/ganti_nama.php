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
				
				<div class="form-group row">
					<div class="col">
						<label for="nama" class="form-label">Masukkan Nama</label>
						<input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?=$admin['nama']?>" required>
						<small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
						<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
						<small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
						<small class="form-text text-danger"><?= form_error('password', '<p class="mb-0">', '</p>') ?></small>
						<small class="form-text text-danger"><?= form_error('passconf', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col">
						<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
						<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h4><?=$judul?></h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-6">
			<div class="card card-round">
				<div class="card-body p-4">
					<form action="" method="post">
						<input type="hidden" name="id_user" id="id_user" value="<?= $akuntan['id_user'] ?>">
						<input type="hidden" name="tipe" id="tipe" value="password">
						
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
								<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

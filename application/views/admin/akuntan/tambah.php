<div class="content container-fluid">
	<div class="card card-round card-shadow">
		<div class="card-body px-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="row mb-4 text-center">
						<div class="col">
							<h4><?=$judul?></h4>
						</div>
					</div>
					
					<form action="" method="post">
						<input type="hidden" name="level" id="level" value="<?=$level?>">
						
						<!-- Nama -->
						<div class="form-group row">
							<div class="col-sm">
								<input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?= set_value('nama') ?>" required>
								<small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Email -->
						<div class="form-group row">
							<div class="col-sm">
								<input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?= set_value('email') ?>" required>
								<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Username -->
						<div class="form-group row">
							<div class="col-sm">
								<input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?= set_value('username') ?>" required>
								<small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Password -->
						<div class="form-group row">
							<div class="col-sm">
								<input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
								<small class="form-text text-danger"><?= form_error('password', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Konfirmasi Password -->
						<div class="form-group row">
							<div class="col-sm">
								<input type="password" name="passconf" class="form-control" id="passconf" placeholder="Konfirmasi Password" required>
								<small class="form-text text-danger"><?= form_error('passconf', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row mt-4 text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
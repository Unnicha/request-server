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
						<!-- Kode KLU -->
						<div class="form-group row">
							<label for="kode_klu" class="col-sm-4 col-form-label">Kode KLU</label>
							<div class="col-sm">
								<input type="text" name="kode_klu" class="form-control" id="kode_klu" value="<?= set_value('kode_klu') ?>" required autofocus>
								<small class="form-text text-danger"><?= form_error('kode_klu', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Bentuk Usaha -->
						<div class="form-group row">
							<label for="bentuk_usaha" class="col-sm-4 col-form-label">Bentuk Usaha</label>
							<div class="col-sm">
								<input type="text" name="bentuk_usaha" class="form-control" id="bentuk_usaha" value="<?= set_value('bentuk_usaha') ?>" required>
								<small class="form-text text-danger"><?= form_error('bentuk_usaha', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Jenis Usaha -->
						<div class="form-group row">
							<label for="jenis_usaha" class="col-sm-4 col-form-label">Jenis Usaha</label>
							<div class="col-sm">
								<input type="text" name="jenis_usaha" class="form-control" id="jenis_usaha" value="<?= set_value('jenis_usaha') ?>" required>
								<small class="form-text text-danger"><?= form_error('jenis_usaha', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Button -->
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
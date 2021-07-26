<div class="container">
	<div class="row row-child mt-3">
		<div class="col">
			<!-- Judul Form -->
			<h2>Ubah Jenis Data</h2>
		</div>
	</div>
	
	<hr class="my-0">
	
	<!-- Isi Form -->
	<form action="" method="post"> 
		<div class="row row-child mt-4">
			<div class="col col-tambah">
				<input type="hidden" name="kode_jenis" id="kode_jenis" value="<?=$jenis_data['kode_jenis']?>">
				
				<div class="form-group row">
					<label for="kategori" class="col-sm-4 col-form-label">Kategori</label> 
					<div class="col-sm">
						<input type="text" name="kategori" class="form-control" id="kategori" value="<?= $jenis_data['kategori'] ?>" readonly>
						<small class="form-text text-danger"><?= form_error('kategori', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="jenis_data" class="col-sm-4 col-form-label">Jenis Data</label> 
					<div class="col-sm">
						<input type="text" name="jenis_data" class="form-control" id="jenis_data" placeholder="Masukkan Jenis Data" value="<?= $jenis_data['jenis_data'] ?>" required autofocus>
						<small class="form-text text-danger"><?= form_error('jenis_data', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<div class="row mt-5">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary">Perbarui</button>
						<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div> 
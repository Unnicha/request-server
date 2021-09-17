<div class="content container-fluid">
	<div class="card card-round card-shadow">
		<div class="card-body">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="row mb-4 text-center">
						<div class="col">
							<h3><?=$judul?></h3>
						</div>
					</div>
					
					<form action="" method="post"> 
						<input type="hidden" name="kode_jenis" id="kode_jenis" value="<?=$jenis_data['kode_jenis']?>">
						
						<div class="form-group row">
							<label for="kategori" class="col-md-3 col-form-label">Kategori</label> 
							<div class="col-sm">
								<input type="text" name="kategori" class="form-control" id="kategori" value="<?= $jenis_data['kategori'] ?>" readonly>
								<small class="form-text text-danger"><?= form_error('kategori', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="jenis_data" class="col-md-3 col-form-label">Jenis Data</label> 
							<div class="col-sm">
								<input type="text" name="jenis_data" class="form-control" id="jenis_data" placeholder="Masukkan Jenis Data" value="<?= $jenis_data['jenis_data'] ?>" required autofocus>
								<small class="form-text text-danger"><?= form_error('jenis_data', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row mt-3 text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Perbarui</button>
								<a href="<?=base_url()?>admin/master/jenis_data" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> 
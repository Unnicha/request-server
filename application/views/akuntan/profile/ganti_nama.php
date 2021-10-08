<div class="content container-fluid">
	<div class="card card-round card-shadow">
		<div class="card-body p-5">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<h3 class="mb-3 text-center"><?=$judul?></h3>
					
					<form action="" method="post"> 
						<input type="hidden" name="id_user" id="id_user" value="<?= $akuntan['id_user'] ?>">
						<input type="hidden" name="tipe" id="tipe" value="nama">
						
						<div class="form-group row">
							<div class="col">
								<label for="nama" class="form-label">Masukkan Nama</label>
								<input type="text" name="nama" class="form-control" placeholder="Nama" value="<?=$akuntan['nama']?>" required>
								<small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row mt-4 text-right">
							<div class="col">
								<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
								<a href="<?=base_url()?>akuntan/profile" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

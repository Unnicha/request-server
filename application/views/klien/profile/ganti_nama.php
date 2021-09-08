<div class="content container-fluid">
	<h3 class="mb-3"><?=$judul?></h3>
	
	<div class="card card-round card-shadow">
		<div class="cad-body p-4">
			<div class="row">
				<div class="col">
					<form action="" method="post">
						<input type="hidden" name="tipe" value="<?=$tipe?>">
						<input type="hidden" name="table" value="<?=$table?>">
						<input type="hidden" name="id_klien" value="<?=$klien['id_klien']?>">
						
						<div class="form-group row">
							<div class="col">
								<label for="nama" class="form-label">Masukkan Nama</label>
								<input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?=$klien['nama']?>" required>
								<small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
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
	</div>
</div>

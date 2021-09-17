<div class="content container-fluid">
	<h3 class="mb-3"><?=$judul?></h3>
	
	<div class="card card-round card-shadow">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<form action="" method="post">
						<input type="hidden" name="tipe" value="<?=$tipe?>">
						<input type="hidden" name="table" value="<?=$table?>">
						<input type="hidden" name="id_klien" value="<?=$klien['id_klien']?>">
						
						<!-- Nama Counterpart -->
						<div class="form-group row">
							<label for="nama_counterpart" class="col-sm-4 col-form-label">Nama</label> 
							<div class="col-sm">
								<input type="text" name="nama_counterpart" class="form-control" id="nama_counterpart" value="<?= $klien['nama_counterpart'] ?>">
								<small class="form-text text-danger"><?= form_error('nama_counterpart', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- No. HP Counterpart -->
						<div class="form-group row">
							<label for="no_hp_counterpart" class="col-sm-4 col-form-label">
								Nomor HP
							</label> 
							<div class="col-sm">
								<input type="text" name="no_hp_counterpart" class="form-control" id="no_hp_counterpart" value="<?= $klien['no_hp_counterpart'] ?>">
								<small class="form-text text-danger"><?= form_error('no_hp_counterpart', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Email Counterpart -->
						<div class="form-group row">
							<label for="email_counterpart" class="col-sm-4 col-form-label">
								Email
							</label> 
							<div class="col-sm">
								<input type="text" name="email_counterpart" class="form-control" id="email_counterpart" value="<?= $klien['email_counterpart'] ?>">
								<small class="form-text text-danger"><?= form_error('email_counterpart', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Perbarui</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

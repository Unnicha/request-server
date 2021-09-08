<div class="content container-fluid">
	<h3 class="mb-3"><?=$judul?></h3>
	
	<div class="card card-round card-shadow">
		<div class="card-body p-4">
			<form action="" method="post">
				<input type="hidden" name="tipe" value="<?=$tipe?>">
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="id_klien" value="<?=$klien['id_klien']?>">
				
				<div class="form-group row">
					<div class="col">
						<label for="email" class="form-label">Masukkan Email</label>
						<input type="text" name="email" class="form-control" value="<?=$klien['email_user']?>" placeholder="Email" required>
						<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
						<?php if($this->session->flashdata('email')) : ?>
							<small class="form-text text-danger">
								<?= $this->session->flashdata('email'); ?>
							</small>
						<?php endif; ?>
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

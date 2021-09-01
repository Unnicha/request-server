<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-round">
				<div class="card-body p-4">
					<form action="" method="post"> 
						<input type="hidden" name="id_user" id="id_user" value="<?= $admin['id_user'] ?>">
						
						<div class="form-group row">
							<div class="col">
								<label for="email" class="form-label">Masukkan Email Baru</label>
								<input type="text" name="email" class="form-control" id="email" placeholder="Email" required>
								<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
								<?php if($this->session->flashdata('email')) : ?>
									<small class="form-text text-danger">
										<?= $this->session->flashdata('email'); ?>
									</small>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="row mt-3 text-right">
							<div class="col">
								<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
								<a href="<?= base_url(); ?>admin/profile" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

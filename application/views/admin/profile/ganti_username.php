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
								<label for="username" class="form-label">Masukkan Username Baru</label>
								<input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
								<small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
								<?php if($this->session->flashdata('username')) : ?>
									<small class="form-text text-danger">
										<?= $this->session->flashdata('username'); ?>
									</small>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="row mt-3 text-right">
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

<div class="content container-fluid">
	<div class="card card-round">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="row mb-2 text-center">
						<div class="col">
							<h3><?=$judul?></h3>
						</div>
					</div>
					
					<form action="" method="post"> 
						<input type="hidden" name="id_user" id="id_user" value="<?= $admin['id_user'] ?>">
						
						<?php $value = (set_value('username')) ? set_value('username') : $admin['username']; ?>
						<div class="form-group row">
							<div class="col">
								<label for="username" class="form-label">Masukkan Username</label>
								<input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?=$value?>" required>
								<small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
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

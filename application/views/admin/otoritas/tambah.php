<div class="container-fluid">
    <div class="row row-child mt-3">
        <div class="col">
            <!-- Judul Form -->
            <h3><?=$judul?></h3>
        </div>
    </div>
    
    <hr class="my-0">

    <!-- Isi Form -->
    <form action="" method="post"> 
        <div class="row row-child my-4">
            <div class="col col-tambah">
                <input type="hidden" name="level" id="level" value="<?= $level ?>">
                
                <!-- Nama User -->
                <div class="form-group row">
                    <label for="lama_pengerjaan" class="col-sm-4 col-form-label">
						Nama Admin
					</label> 
                    <div class="col-sm">
                        <input type="text" name="nama" class="form-control" id="nama" value="<?= set_value('nama') ?>" required autofocus>
                        <small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Email User -->
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label">Email</label> 
                    <div class="col-sm">
                        <input type="text" name="email" class="form-control" id="email" value="<?= set_value('email') ?>" required>
                        <small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Username -->
                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label">
                        Username
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="username" class="form-control" id="username" value="<?= set_value('username') ?>" required>
                        <small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Password -->
                <div class="form-group row">
                    <label for="password" class="col-sm-4 col-form-label">
                        Password
                    </label> 
                    <div class="col-sm">
                        <input type="password" name="password" class="form-control" id="password" required>
                        <small class="form-text text-danger"><?= form_error('password', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group row">
                    <label for="passconf" class="col-sm-4 col-form-label">Konfirmasi</label> 
                    <div class="col-sm">
                        <input type="password" name="passconf" class="form-control" id="passconf" required>
                        <small class="form-text text-danger"><?= form_error('passconf', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
            
                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary mr-1">
                            Simpan
                        </button>
                        <a href="<?=base_url()?>admin/otoritas" type="submit" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
		$('#menu1').collapse('show');
</script>
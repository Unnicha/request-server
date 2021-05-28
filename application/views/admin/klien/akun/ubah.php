<div class="container-fluid">
    <!-- Judul Form -->
    <div class="row row-child mt-3">
        <div class="col">
            <h2><?= $judul ?></h2>
        </div>
    </div>
    
    <hr class="my-0 ">

    <!-- Isi Form -->
    <div class="row row-child mt-4">
        <div class="col col-tambah">
            <form action="" method="post"> 
                <input type="hidden" name="level" id="level" value="<?=$klien['level']?>">
                
                <div class="form-group row">
                    <label for="id_klien" class="col-sm-4 col-form-label">
                        ID Klien
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="id_klien" class="form-control" id="id_klien" value="<?= $klien['id_klien'] ?>" readonly>
	                    </div>
                </div>
                
                <!-- Nama Klien -->
                <div class="form-group row">
                    <label for="nama_klien" class="col-sm-4 col-form-label">
                        Nama Klien
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="nama_klien" class="form-control" id="nama_klien" value="<?= $klien['nama_klien'] ?>" required autofocus>
                        <small class="form-text text-danger">
                            <?= form_error('nama_klien', '<p class="mb-0">', '</p>') ?>
                        </small>
                    </div>
                </div>
                
                <!-- Email Klien -->
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label">
                        Email Klien
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="email" class="form-control" id="email" value="<?= $klien['email_user'] ?>" required>
                        <small class="form-text text-danger">
							<?= form_error('email', '<p class="mb-0">', '</p>') ?>
						</small>
                    </div>
                </div>

                <!-- Username -->
                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label">
                        Username
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="username" class="form-control" id="username" value="<?= $klien['username'] ?>" required>
						<small class="form-text text-danger">
							<?= form_error('username', '<p class="mb-0">', '</p>') ?>
						</small>
                    </div>
                </div>
                
                <!-- Password -->
                <div class="form-group row">
                    <label for="password" class="col-sm-4 col-form-label">
                        Password
                    </label> 
                    <div class="col-sm">
                        <input type="password" name="password" class="form-control" id="password" required>
                        <small class="form-text text-danger">
							<?= form_error('password', '<p class="mb-0">', '</p>') ?>
						</small>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary mr-1">
                            Perbarui
                        </button>
                        <a href="<?= base_url(); ?>admin/klien" type="submit" name="tambah" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
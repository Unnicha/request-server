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
                <input type="hidden" name="level" id="level" value="<?=$akuntan['level']?>">
                <input type="hidden" name="id_user" id="id_user" value="<?=$akuntan['id_user']?>">

                <!-- Nama Akuntan -->
                <div class="form-group row">
                    <label for="nama" class="col-sm-4 col-form-label">
                        Nama Akuntan
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="nama" class="form-control" id="nama" value="<?= $akuntan['nama'] ?>" required>
                        <small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>

                <!-- Email Akuntan -->
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label">
                        Email Akuntan
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="email" class="form-control" id="email" value="<?= $akuntan['email_user'] ?>" required>
                        <small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
            
                <!-- Username -->
                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label">
                        Username
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="username" class="form-control" id="username" value="<?= $akuntan['username'] ?>" required>
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
                
                <div class="row mt-5">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary mr-2">
                            Ubah
                        </button>
                        <a href="<?= base_url(); ?>admin/master/akuntan" class="btn btn-secondary mr-3">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
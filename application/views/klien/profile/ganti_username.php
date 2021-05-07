<div class="container">
    <div class="row justify-content-md-center mt-3 mb-4">
        <div class="col">
            <div class="card ubah-akun mt-3">
                <div class="card-body px-4 mx-3 py-4">
                    <!-- Judul Form -->
                    <h2 class="pb-4 text-center"><?=$judul?></h2>

                    <!-- Isi Form -->
                    <form action="" method="post"> 
                        <input type="hidden" name="id_user" id="id_user" value="<?= $klien['id_user'] ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $klien['nama'] ?>">
                        <input type="hidden" name="level" id="level" value="<?= $klien['level'] ?>">
                        
                        <!-- Username -->
                        <div class="form-group row row-child">
                            <label for="username" class="form-label">Masukkan Username Baru</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                            <small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
                            <?php if($this->session->flashdata('username')) : ?>
                                <small class="form-text text-danger">
                                    <?= $this->session->flashdata('username'); ?>
                                </small>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group row row-child">
                            <label for="password" class="form-label">Masukkan Password Anda</label> 
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            <?php if($this->session->flashdata('pass')) : ?>
                                <small class="form-text text-danger">
                                    <?= $this->session->flashdata('pass'); ?>
                                </small>
                            <?php endif; ?>
                        </div>
                        
                        <div class="row float-right mt-3">
                            <div class="col">
                                <button type="submit" name="simpan" class="btn btn-primary mr-2">
                                    Simpan
                                </button>
                                <a href="<?= base_url(); ?>klien/profile" type="submit" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-md-center mt-3 mb-4">
        <div class="col">
            <div class="card ubah-akun mt-3">
                <div class="card-body px-4 mx-3 py-4">
                    <!-- Judul Form -->
                    <h2 class="pb-4 text-center"><?=$judul?></h2>

                    <!-- Isi Form -->
                    <form action="" method="post"> 
                        <input type="hidden" name="id_user" id="id_user" value="<?= $akuntan['id_user'] ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $akuntan['nama'] ?>">
                        <input type="hidden" name="level" id="level" value="<?= $akuntan['level'] ?>">
                        <input type="hidden" name="username" id="username" value="<?= $akuntan['username'] ?>">
                        
                        <!-- Password -->
                        <div class="row row-child mb-4">
                            <label for="passlama" class="form-label">Masukkan Password Lama</label> 
                            <input type="password" name="passlama" class="form-control" id="passlama" placeholder="Password" required>
                            <?php if($this->session->flashdata('pass')) : ?>
                                <small class="form-text text-danger">
                                    <?= $this->session->flashdata('pass'); ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <!-- Password -->
                        <div class="form-group row row-child">
                            <label for="password" class="form-label">Masukkan Password Baru</label> 
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            <small class="form-text text-danger"><?= form_error('password', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group row row-child">
                            <label for="passconf" class="form-label">Konfirmasi Password</label> 
                            <input type="password" name="passconf" class="form-control" id="passconf" placeholder="Password" required>
                            <small class="form-text text-danger"><?= form_error('passconf', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                        
                        <div class="row float-right mt-3">
                            <div class="col">
                                <button type="submit" name="simpan" class="btn btn-primary mr-2">
                                    Simpan
                                </button>
                                <a href="<?= base_url(); ?>akuntan/profile" type="submit" class="btn btn-secondary">
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

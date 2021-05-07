<div class="container-fluid mb-4">
    <h2 align="center">Profil Klien</h2>
    <p class="subheader mb-2 text-center"> 
        Detail info Usaha, Pimpinan dan Counterpart
    </p>

    <hr class="my-0 hr-profil">

    <?php if($this->session->flashdata('flash')) : ?>
    <div class="row">
        <div class="col">
            <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                Berhasil <b><?= $this->session->flashdata('flash'); ?></b>!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row row-child py-3 px-4">
        <div class="col">
            <!-- Header Card -->
            <div class="row mb-3">
                <div class="col">
                    <h5 class="card-title">Info Akun</h5>
                    <p class="card-subtitle text-muted">
                        Anda bisa melakukan perubahan pada Username dan Password. 
                    </p>
                </div>
            </div>
            
            <!-- Isi Card -->
            <div class="row">
                <div class="col-4"> ID Klien </div>
                <div class="col"> <?= $klien['id_klien'] ?> </div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-4"> Nama Klien </div>
                <div class="col"> <?= $klien['nama_klien'] ?> </div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col"> Username </div>
                <div class="col"> <?= $klien['username'] ?> </div>
                <div class="col">
                    <a href="<?= base_url(); ?>klien/profile/ganti_username" type="button" class="float-right">
                        ganti username
                    </a>
                </div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col"> Password </div>
                <div class="col">
                    <input type="password" class="form-control-plaintext py-0" id="password" value="<?= $klien['password'] ?>" readonly>
                </div>
                <div class="col">
                    <a href="<?= base_url(); ?>klien/profile/ganti_password" type="button" class="float-right">
                        ganti password
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-0 hr-profil">

    <div class="row row-child py-3 px-4">
        <div class="col">
            <!-- Header Card -->
            <div class="row mb-3">
                <div class="col">
                    <h5 class="card-title">Info Usaha</h5>
                    <p class="card-subtitle text-muted"></p>
                </div>
            </div>

            <!-- Isi Card -->
            <div class="row">
                <div class="col-5">Nama Usaha</div>
                <div class="col"><?= $klien['nama_usaha']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Kode KLU</div>
                <div class="col"><?= $klien['kode_klu']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Bentuk Usaha</div>
                <div class="col"><?= $klien['bentuk_usaha']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Jenis Usaha</div>
                <div class="col"><?= $klien['jenis_usaha']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Alamat</div>
                <div class="col"><?= $klien['alamat']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Nomor Telepon</div>
                <div class="col"><?= $klien['telp']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Email</div>
                <div class="col"><?= $klien['email']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Nomor HP</div>
                <div class="col"><?= $klien['no_hp']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Nomor Akte Terakhir</div>
                <div class="col"><?= $klien['no_akte']; ?></div>
            </div>
        </div>
    </div>

    <hr class="my-0 hr-profil">

    <div class="row row-child py-3 px-4">
        <div class="col">
            <!-- Header Card -->
            <div class="row mb-3">
                <div class="col">
                    <h5 class="card-title">Pimpinan</h5>
                    <p class="card-subtitle text-muted"></p>
                </div>
            </div>

            <!-- Isi Card -->
            <div class="row">
                <div class="col-5">Nama Pimpinan</div>
                <div class="col"><?= $klien['nama_pimpinan']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Jabatan</div>
                <div class="col"><?= $klien['jabatan']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Email Pimpinan</div>
                <div class="col"><?= $klien['email_pimpinan']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Nomor HP Pimpinan</div>
                <div class="col"><?= $klien['no_hp_pimpinan']; ?></div>
            </div>
        </div>
    </div>

    <hr class="my-0 hr-profil">

    <div class="row row-child py-3 px-4">
        <div class="col">
            <!-- Header Card -->
            <div class="row mb-3">
                <div class="col">
                    <h5 class="card-title">Counterpart</h5>
                    <p class="card-subtitle text-muted"></p>
                </div>
            </div>

            <!-- Isi Card -->
            <div class="row">
                <div class="col-5">Nama Counterpart</div>
                <div class="col"><?= $klien['nama_counterpart']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Email Counterpart</div>
                <div class="col"><?= $klien['email_counterpart']; ?></div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-5">Nomor HP Counterpart</div>
                <div class="col"><?= $klien['no_hp_counterpart']; ?></div>
            </div>
        </div>
    </div>
</div>

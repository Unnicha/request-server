<div class="container-fluid mb-4">
    <div class="row row-child">
        <div class="col">
            <h2 class="text-center mb-2">Profil Akuntan</h2> 
        </div>
    </div>
    
    <hr class="hr-profil my-0">

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
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Info Akun</h5>
                    <p class="card-subtitle text-muted mb-4"> 
                        Anda bisa melakukan perubahan pada Username dan Password. 
                    </p>
                </div>
            </div>

            <!-- Isi Card -->
            <div class="row">
                <div class="col-4"> ID Akuntan </div>
                <div class="col"> <?= $akuntan['id_user'] ?> </div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col-4"> Nama Akuntan </div>
                <div class="col"> <?= $akuntan['nama'] ?> </div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col"> Username </div>
                <div class="col"> <?= $akuntan['username'] ?> </div>
                <div class="col">
                    <a href="<?= base_url(); ?>akuntan/profile/ganti_username" type="button" class="float-right">
                        ganti username
                    </a>
                </div>
            </div>
            <hr class="solid batas-profil">
            <div class="row">
                <div class="col"> Password </div>
                <div class="col">
                    <input type="password" readonly class="form-control-plaintext" id="password" value="<?= $akuntan['password'] ?>">
                </div>
                <div class="col">
                    <a href="<?= base_url(); ?>akuntan/profile/ganti_password" type="button" class="float-right">
                        ganti username
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr class="hr-profil my-0">

</div>

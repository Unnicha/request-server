<div class="container">
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
                
                <!-- Kode KLU -->
                <div class="form-group row">
                    <label for="kode_klu" class="col-sm-4 col-form-label">
                        Kode KLU
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="kode_klu" class="form-control" id="kode_klu" value="<?= $klu['kode_klu'] ?>" readonly>
                        <small class="form-text text-danger"><?= form_error('kode_klu', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
            
                <!-- Bentuk Usaha -->
                <div class="form-group row">
                    <label for="bentuk_usaha" class="col-sm-4 col-form-label">
                        Bentuk Usaha
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="bentuk_usaha" class="form-control" id="bentuk_usaha" value="<?= $klu['bentuk_usaha'] ?>">
                        <small class="form-text text-danger"><?= form_error('bentuk_usaha', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Jenis Usaha -->
                <div class="form-group row">
                    <label for="jenis_usaha" class="col-sm-4 col-form-label">Jenis Usaha</label> 
                    <div class="col-sm">
                        <input type="text" name="jenis_usaha" class="form-control" id="jenis_usaha" value="<?= $klu['jenis_usaha'] ?>">
                        <small class="form-text text-danger"><?= form_error('jenis_usaha', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary mr-1">
                            Ubah
                        </button>
                        <a href="<?= base_url(); ?>admin/master/klu" type="submit" name="tambah" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div> 
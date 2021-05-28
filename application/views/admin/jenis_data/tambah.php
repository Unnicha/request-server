<div class="container">
    <div class="row row-child mt-3">
        <div class="col">
            <!-- Judul Form -->
            <h3>Tambah Jenis Data</h3>
        </div>
    </div>
    
    <hr class="my-0">

    <!-- Isi Form -->
    <form action="" method="post"> 
        <div class="row row-child my-4">
            <div class="col col-tambah">
                <!-- Kode Jenis -->
                <!--
                <div class="form-group row">
                    <label for="kode_jenis" class="col-sm-4 col-form-label">
                        Kode Jenis
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="kode_jenis" class="form-control" id="kode_jenis" placeholder="Masukkan Kode Jenis" value="<?= set_value('kode_jenis') ?>" required autofocus>
                        <small class="form-text text-danger"><?= form_error('kode_jenis', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                -->
                    
                <!-- Kategori -->
                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Kategori</label> 
                    <div class="col-sm">
                        <select name='kategori' class="form-control" id="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                                <?php 
                                    $input = set_value('kategori');
                                    foreach ($kategori as $k => $val) : 
                                        if($val == $input) {
                                    $pilih = "selected";
                                        } else {
                                    $pilih = "";
                                        }
                                ?>
                            <option <?=$pilih?>><?= $val; ?></option>
                                <?php endforeach ?>
                        </select>
                        <small class="form-text text-danger"><?= form_error('kategori', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Jenis Data -->
                <div class="form-group row">
                    <label for="jenis_data" class="col-sm-4 col-form-label">
                        Jenis Data
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="jenis_data" class="form-control" id="jenis_data" placeholder="Masukkan Jenis Data"  value="<?= set_value('jenis_data') ?>" required>
                        <small class="form-text text-danger"><?= form_error('jenis_data', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="row mt-5">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="<?= base_url(); ?>admin/jenis_data" type="submit" name="tambah" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div> 
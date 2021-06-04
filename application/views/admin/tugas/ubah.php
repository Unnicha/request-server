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

                <!-- ID Tugas -->
                <div class="form-group row">
                    <label for="id_tugas" class="col-sm-4 col-form-label">
                        ID Tugas
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="id_tugas" class="form-control" id="id_tugas" placeholder="Masukkan ID Tugas" value="<?= $tugas['id_tugas'] ?>" readonly>
                        <small class="form-text text-danger"><?= form_error('id_tugas', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Nama Tugas -->
                <div class="form-group row">
                    <label for="nama_tugas" class="col-sm-4 col-form-label">
                        Nama Tugas
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="nama_tugas" class="form-control" id="nama_tugas" placeholder="Masukkan Nama Tugas" value="<?= $tugas['nama_tugas'] ?>" required autofocus>
                        <small class="form-text text-danger"><?= form_error('nama_tugas', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                    
                <!-- Jenis Data -->
                <div class="form-group row">
                    <label for="kode_jenis" class="col-sm-4 col-form-label">
                        Jenis Data
                    </label> 
                    <div class="col-sm">
                        <select name='kode_jenis' class="form-control" id="kode_jenis" readonly>
                            <option value="<?= $tugas['kode_jenis'] ?>"><?= $tugas['jenis_data'] ?></option>
                        </select>
                    </div>
                </div>

                <!-- Status Pekerjaan -->
                <div class="form-group row">
                    <label for="status_pekerjaan" class="col-sm-4 col-form-label">Status Pekerjaan</label> 
                    <div class="col-sm">
                        <select name='status_pekerjaan' class="form-control" id="status_pekerjaan" readonly>
                            <option value="<?= $tugas['status_pekerjaan'] ?>">
                                <?= $tugas['status_pekerjaan'] ?>
                            </option>
                        </select>
                        <small class="form-text text-danger"><?= form_error('status_pekerjaan', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <!-- Lama Pengerjaan -->
                <div class="form-group row">
                    <label for="hari" class="col-sm-4 col-form-label">
                        Lama Pengerjaan
                    </label> 
                    <div class="col-sm">
                        <div class="row">
                            <div class="col px-0 input-group">
                                <input type="number" name="hari" class="form-control" min="0" value="<?= $hari ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text rounded-right"> hari </span>
                                </div>
                            </div>
                            <div class="col pl-2 pr-0 input-group">
                                <input type="number" name="jam" class="form-control" min="0" max="7" value="<?= $jam ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text rounded-right"> jam </span>
                                </div>
                            </div>
                        </div>
                        <small class="form-text">Format Jam Kerja (1 hari = 8 jam)</small>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="<?= base_url(); ?>admin/master/tugas" type="submit" name="tambah" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div> 
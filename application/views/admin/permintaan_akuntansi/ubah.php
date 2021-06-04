<div class="container">
    <div class="row justify-content-md-center mt-3 mb-4">
        <div class="col">
            <div class="card card-permintaan">
            <div class="card-body" style="margin:5px;">
                <!-- Judul Form -->
                <h2 class="mb-4" align="center"><?= $header; ?></h2>
                
                <!-- Notifikasi -->
                <?php if($this->session->flashdata('flash')) : ?>
                    <div class="row" style="text-align: center">
                        <div class="col">
                            <p class="text-danger">
                                Permintaan data <?= $this->session->flashdata('flash'); ?>.
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Isi Form -->
                <form action="" method="post"> 
                    
                    <!-- Tanggal Permintaan -->
                    <?php $tanggal = date('d-m-Y H:i') ?>
                    <div class="form-group row">
                        <label for="tanggal_permintaan" class="col-sm-4 col-form-label">
                            Tanggal Permintaan
                        </label> 
                        <div class="col-sm">
                            <input type="text" name="tanggal_permintaan" class="form-control" id="tanggal_permintaan" value="<?= $tanggal; ?>" readonly>
                            <small class="form-text text-danger"><?= form_error('tanggal_permintaan', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                    </div>
                    
                    <!-- Klien -->
                    <div class="form-group row">
                        <label for="id_klien" class="col-sm-4 col-form-label">Klien</label> 
                        <div class="col-sm">
                            <select name='id_klien' class="form-control" id="id_klien" required>
                                <?php 
                                    foreach ($klien as $k) : 
                                        if($k['id_klien'] == $permintaan['id_klien']) {
                                            $pilih = "selected";
                                        } else {
                                            $pilih = "";
                                        }
                                ?>
                                <option value="<?= $k['id_klien']; ?>" <?=$pilih?>>
                                    <?= $k['nama_klien']; ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                            <small class="form-text text-danger"><?= form_error('id_klien', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                    </div>

                    <!-- Jenis Data -->
                    <div class="form-group row">
                        <label for="jenis_data" class="col-sm-4 col-form-label">Jenis Data</label> 
                        <div class="col-sm">
                            <select name='kode_jenis' class="form-control" id="kode_jenis" required>
                                <?php 
                                    foreach ($jenis as $j) : 
                                        if ($j['kategori'] == 'Data Akuntansi') : 
                                            if($j['kode_jenis'] == $permintaan['kode_jenis']) {
                                                $pilih = "selected";
                                            } else {
                                                $pilih = "";
                                            }
                                ?>
                                <option value="<?= $j['kode_jenis']; ?>" <?=$pilih?>>
                                    <?= $j['jenis_data']; ?>
                                </option>
                                <?php endif; endforeach ?>
                            </select>
                            <small class="form-text text-danger"><?= form_error('kode_jenis', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                    </div>
                    
                    <!-- Masa -->
                    <div class="form-group row">
                        <label for="masa" class="col-sm-4 col-form-label">Masa</label> 
                        <div class="col-sm">
                            <select name='masa' class="form-control" id="masa" required>
                                <?php 
                                    $bulan = date('m');
                                    foreach ($masa as $m) : 
                                        if ($m['nama_bulan'] == $permintaan['masa']) {
                                            $pilih="selected";
                                        } else{
                                            $pilih="";
                                        }
                                ?>
                                <option <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
                                <?php endforeach ?>
                            </select>
                            <small class="form-text text-danger"><?= form_error('masa', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                    </div>
                    
                    <!-- Tahun -->
                    <div class="form-group row">
                        <label for="tahun" class="col-sm-4 col-form-label">Tahun</label> 
                        <div class="col-sm">
                            <select name='tahun' class="form-control" id="tahun" required>
                                <?php 
                                    $now = date('Y');
                                    for ($i=$now; $i>=2010; $i--) : 
                                        if ($i == $permintaan['tahun']) {
                                            $pilih="selected";
                                        } else{
                                            $pilih="";
                                        }
                                ?>
                                <option <?=$pilih?>><?= $i; ?></option>
                                    <?php endfor; ?>
                            </select>
                            <small class="form-text text-danger"><?= form_error('tahun', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                    </div>
                    
                    <!-- Keterangan -->
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-4 col-form-label">Keterangan</label> 
                        <div class="col-sm">
                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Tambahkan Keterangan" value="<?=$permintaan['keterangan']?>">
                            <small class="form-text text-danger"><?= form_error('keterangan', '<p class="mb-0">', '</p>') ?></small>
                        </div>
                    </div>
                    
                    <!-- Level -->
                    <input type="hidden" name="id_permintaan" value="<?=$permintaan['id_permintaan']?>">
                    <input type="hidden" name="level" value="<?=$this->session->userdata('level')?>">
                    
                    <!-- Tombol Simpan -->
                    <div class="row float-right mt-2">
                        <button type="submit" name="tambah" class="btn btn-primary mr-2">
                            Perbarui 
                        </button>
                        <a href="<?= base_url(); ?>admin/permintaan/permintaan_data_akuntansi" class="btn btn-secondary mr-3">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

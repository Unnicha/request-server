<div class="container-fluid">
    <div class="row row-child">
        <div class="col">
            <!-- Judul Form -->
            <h2 class="mb-2"><?=$judul?></h2>
        </div>
    </div>
    
    <hr class="my-0">

    <div class="row row-child mt-4">
        <div class="col col-tambah">
            <?php if($this->session->flashdata('flash')) : ?>
            <div class="row mt-3">
                <div class="col md-6">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('flash'); ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Isi Form -->
            <form action="" method="post" enctype="multipart/form-data"> 
                <input type="hidden" id="id_permintaan" name="id_permintaan" value="<?= $permintaan['id_permintaan'] ?>">
            
                <!-- Tanggal Pengiriman -->
                <?php $tanggal = date('d-m-Y H:i') ?>
                <div class="form-group row">
                    <label for="tanggal_pengiriman" class="col-sm-5 col-form-label">
                        Tanggal Pengiriman
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="tanggal_pengiriman" class="form-control" id="tanggal_pengiriman" value="<?= $tanggal; ?>" readonly>
                    </div>
                </div>

                <!-- Jenis Data -->
                <div class="form-group row">
                    <label for="kode_jenis" class="col-sm-5 col-form-label">Jenis Data</label> 
                    <div class="col-sm">
                        <input type="text" class="form-control" value="<?= $permintaan['jenis_data']; ?>" readonly>
                    </div>
                </div>

                <!-- Masa -->
                <div class="form-group row">
                    <label for="masa" class="col-sm-5 col-form-label">Masa</label> 
                    <div class="col-sm">
                        <input type="text" id="masa" name="masa" class="form-control" value="<?= $permintaan['masa']; ?>" readonly>
                    </div>
                </div>

                <!-- Tahun -->
                <div class="form-group row">
                    <label for="tahun" class="col-sm-5 col-form-label">Tahun</label> 
                    <div class="col-sm">
                        <input type="text" id="tahun" name="tahun" class="form-control" value="<?= $permintaan['tahun']; ?>" readonly>
                    </div>
                </div>

                <!-- Masa -->
                <div class="form-group row">
                    <label for="format_data" class="col-sm-5 col-form-label">Format Data</label> 
                    <div class="col-sm">
                        <input type="text" id="format_data" name="format_data" class="form-control" value="<?= $permintaan['format_data']; ?>" readonly>
                    </div>
                </div>

                <?php if($permintaan['format_data'] == 'Softcopy') : ?>
                <div class="form-group row">
                    <label for="file" class="col-sm-5 col-form-label">
                        File
                    </label> 
                    <div class="col-sm">
                        <input type="file" name="file" class="form-control" id="file">
                        <small class="form-text text-danger"><?= form_error('file', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                <?php else : ?>
                <!-- Tanggal Pengambilan -->
                <div class="form-group row">
                    <label for="tanggal_ambil" class="col-sm-5 col-form-label">
                        Tanggal Pengambilan
                    </label> 
                    <div class="col-sm">
                        <input type="date" name="tanggal_ambil" class="form-control" id="tanggal_ambil" placeholder="Masukkan Tanggal Pengambilan">
                        <small class="form-text text-danger"><?= form_error('tanggal_ambil', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                <?php endif ?>

                <!-- Keterangan -->
                <div class="form-group row">
                    <label for="keterangan" class="col-sm-5 col-form-label">
                        Keterangan
                    </label> 
                    <div class="col-sm">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan">
                        <small class="form-text text-danger"><?= form_error('keterangan', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" name="kirim" class="btn btn-primary mr-2">
                            Kirim 
                        </button>
                        <a href="<?=base_url()?>klien/pengiriman_data_perpajakan" name="kirim" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
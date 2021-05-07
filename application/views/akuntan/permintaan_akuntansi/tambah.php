<div class="container-fluid">
    <div class="row row-child mt-2">
        <div class="col">
            <!-- Judul Form -->
            <h3><?= $judul; ?></h3>
        </div>
    </div>
    
    <hr class="my-0">

    <div class="row row-child my-4">
        <div class="col col-tambah">

        <!-- Notifikasi -->
        <?php if($this->session->flashdata('flash')) : ?>
            <div class="row">
                <div class="col">
                    <p class="text-danger">
                        Permintaan data <?= $this->session->flashdata('flash'); ?>.
                    </p> 
                </div>
            </div>
        <?php endif; ?>

        <!-- Isi Form -->
        <form action="" method="post">
            <input type="hidden" name="level" value="<?=$this->session->userdata('level')?>">
            <input type="hidden" name="id_user" value="<?=$this->session->userdata('id_user')?>">
            
            <!-- Tanggal Permintaan -->
            <?php $tanggal = date('d-m-Y H:i') ?>
            <div class="form-group row">
                <label for="tanggal_permintaan" class="col-sm-5 col-form-label">
                    Tanggal Permintaan
                </label> 
                <div class="col-sm">
                    <input type="text" name="tanggal_permintaan" class="form-control" id="tanggal_permintaan" value="<?= $tanggal; ?>" readonly>
                    <small class="form-text text-danger"><?= form_error('tanggal_permintaan', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Masa -->
            <div class="form-group row">
                <label for="masa" class="col-sm-5 col-form-label">Masa</label> 
                <div class="col-sm">
                    <select name='masa' class="form-control" id="masa" required autofocus>
                        <!--<option value="">--Pilih Masa--</option>-->
                        <?php 
                            $bulan = date('m');
                            foreach ($masa as $m) : 
                                if ($m['id_bulan'] == $bulan) {
                                    $pilih="selected";
                                } else{
                                    $pilih="";
                                }
                        ?>
                        <option value="<?= $m['nama_bulan'] ?>" <?=$pilih?>><?= $m['nama_bulan'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="form-text text-danger"><?= form_error('masa', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Tahun -->
            <div class="form-group row">
                <label for="tahun" class="col-sm-5 col-form-label">Tahun</label> 
                <div class="col-sm">
                    <select name='tahun' class="form-control" id="tahun" required>
                        <!--<option value="">--Pilih Tahun--</option>-->
                        <?php 
                            $now = date('Y');
                            for ($i=$now; $i>=2010; $i--) : 
                        ?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <small class="form-text text-danger"><?= form_error('tahun', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Jenis Data -->
            <div class="form-group row">
                <label for="jenis_data" class="col-sm-5 col-form-label">Jenis Data</label> 
                <div class="col-sm">
                    <select name='kode_jenis' class="form-control" id="kode_jenis" required>
                        <option value="" selected>--Pilih Jenis Data--</option>
                        <?php 
                            foreach ($jenis as $j) : 
                                if ($j['kategori'] == 'Data Akuntansi') : 
                        ?>
                        <option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
                        <?php endif; endforeach ?>
                    </select>
                    <small class="form-text text-danger"><?= form_error('kode_jenis', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Klien -->
            <div class="form-group row">
                <label for="id_klien" class="col-sm-5 col-form-label">Klien</label> 
                <div class="col-sm">
                    <select name='id_klien' class="form-control" id="id_klien" required>
                        <option value="" selected>--Tidak ada akses--</option>
                    </select>
                    <small class="form-text text-danger"><?= form_error('id_klien', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Format Data -->
            <div class="form-group row">
                <label for="format_data" class="col-sm-5 col-form-label">Format Data</label> 
                <div class="col-sm">
                    <select name='format_data' class="form-control" id="format_data" required>
                        <option value="" selected>--Pilih Format Data--</option>
                        <option value="Softcopy">Softcopy</option>
                        <option value="Hardcopy">Hardcopy</option>
                    </select>
                    <small class="form-text text-danger"><?= form_error('format_data', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Keterangan -->
            <div class="form-group row">
                <label for="keterangan" class="col-sm-5 col-form-label">
                    Keterangan
                </label> 
                <div class="col-sm">
                    <input type="text" name="keterangan" class="form-control" id="keterangan" value="<?=set_value('keterangan')?>" placeholder="Tambahkan Keterangan">
                    <small class="form-text text-danger"><?= form_error('keterangan', '<p class="mb-0">', '</p>') ?></small>
                </div>
            </div>
            
            <!-- Tombol Simpan -->
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" name="tambah" class="btn btn-primary mr-1">
                        Kirim
                    </button>
                    <a href="<?= base_url(); ?>akuntan/permintaan_data_akuntansi" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        function getKlien() {
            var bulan = $('#masa').find(':selected').val();
            var tahun = $('#tahun').find(':selected').val();
            $.ajax({
                type : 'POST',
                url : '<?=base_url()?>akuntan/permintaan_data_akuntansi/klien',
                data : {bulan : bulan, tahun : tahun},
                success : function(data) {
                    $('#id_klien').html(data);
                }
            })
        }
        getKlien();

        $('#masa').change(function() {
            getKlien();
        })
        $('#tahun').change(function() {
            getKlien();
        })
    })
</script>
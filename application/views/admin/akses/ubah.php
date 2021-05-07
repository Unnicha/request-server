<div class="container-fluid">
    <div class="row row-child mt-3">
        <div class="col">
            <!-- Judul Form -->
            <h3><?=$judul?></h3>
        </div>
    </div>

    <hr class="my-0">
    
    <?php if($this->session->flashdata('sudah')) : ?>
    <div class="row mt-3">
        <div class="col">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data akses <?= $this->session->flashdata('sudah'); ?>!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Isi Form -->
    <form action="" method="post"> 
        <div class="row row-child">
            <div class="col col-tambah">
                <input type="hidden" id="id_akses" name="id_akses" value="<?=$akses['id_akses']?>">
                <input type="hidden" id="id_akuntan" name="id_akuntan" value="<?=$akses['id_akuntan']?>">
                <!-- ID Akuntan -->
                <div class="form-group row mt-4">
                    <label for="nama" class="col-sm-4 col-form-label">
                        Nama Akuntan
                    </label> 
                    <div class="col-sm">
                        <input type="text" class="form-control" name="nama" id="nama" value="<?=$akses['nama']?>" readonly>
                    </div>
                </div>

                <!-- Masa -->
                <div class="form-group row">
                    <label for="masa" class="col-sm-4 col-form-label">
                        Masa
                    </label> 
                    <div class="col-sm">
                        <input type="text" class="form-control" name="masa" id="masa" value="<?=$akses['masa']?>" readonly>
                    </div>
                </div>

                <!-- Tahun -->
                <div class="form-group row">
                    <label for="tahun" class="col-sm-4 col-form-label">
                        Tahun
                    </label> 
                    <div class="col-sm">
                        <input type="text" class="form-control" name="tahun" id="tahun" value="<?=$akses['tahun']?>" readonly>
                    </div>
                </div>

                <!-- Klien -->
                <div class="form-group row mt-4">
                    <label for="klien" class="col-sm-5 col-form-label">Klien</label> 
                    <div class="col-sm">
                        <?php 
                            $id = explode(",",$akses['klien']);
                            foreach($klien as $k) :
                                if($id == null) {
                                    $pilih = "";
                                } else {
                                    foreach($id as $i => $value) :
                            if($value == $k['id_klien']) {
                                $pilih="checked"; break;
                            } else {
                                $pilih="";
                            }
                                    endforeach; 
                                }
                        ?>
                        <div class="row">
                            <div class="col">
                                <input class="form-check-input" name="klien[]" type="checkbox" value="<?= $k['id_klien'] ?>" id="<?= $k['id_klien'] ?>" <?=$pilih?>>
                                <label class="form-check-label ml-2" for="<?= $k['id_klien'] ?>">
                                    <?= $k['nama_klien'] ?>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <small class="form-text text-danger"><?= form_error('klien[]', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary mr-2">
                            Ubah
                        </button>
                        <a href="<?= base_url(); ?>admin/akses" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
		$('#menu1').collapse('show');
</script>
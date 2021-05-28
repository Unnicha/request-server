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
                <!-- ID Akuntan -->
                <div class="form-group row mt-4">
                    <label for="id_akuntan" class="col-sm-4 col-form-label">
                        Nama Akuntan
                    </label> 
                    <div class="col-sm">
                        <select name="id_akuntan" class="form-control" id="id_akuntan" required>
                            <option value="">--Pilih Akuntan--</option>
                            <?php
                                foreach($akuntan as $ak) :
                                    if($ak['id_user'] == set_value('id_user')) {
                                        $pilih = "selected";
                                    } else {
                                        $pilih = "";
                                    }
                            ?>
                            <option value="<?=$ak['id_user'];?>" <?=$pilih?>> <?=$ak['nama'];?> </option>
                            <?php endforeach ?>
                        </select>
                        <small class="form-text text-danger"><?= form_error('id_akuntan', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>

                <!-- Tahun -->
                <div class="form-group row">
                    <label for="tahun" class="col-sm-4 col-form-label">
                        Tahun
                    </label> 
                    <div class="col-sm">
                        <select name="tahun" class="form-control" id="tahun" required>
                            <?php
                                $tahun = date('Y');
                                for($i=$tahun; $i>=2010; $i--) :
                            ?>
                            <option> <?=$i;?> </option>
                            <?php endfor ?>
                        </select>
                        <small class="form-text text-danger"><?= form_error('tahun', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>

                <!-- Masa -->
                <div class="form-group row">
                    <label for="masa" class="col-sm-4 col-form-label">
                        Bulan Mulai
                    </label> 
                    <div class="col-sm">
                        <select name="masa" class="form-control" id="masa" required>
                            <?php
                                $bulan = date('m');
                                foreach($masa as $m) : 
                                    if($m['id_bulan'] == $bulan) { $pilih = "selected"; } 
									else { $pilih = ""; }
                            ?>
                            <option value="<?=$m['id_bulan']?>" <?=$pilih?>>
								<?=$m['nama_bulan'];?>
							</option>
                            <?php endforeach ?>
                        </select>
                        <small class="form-text text-danger"><?= form_error('masa', '<p class="mb-0">', '</p>') ?></small>
                    </div>
                </div>
				
				<!-- Klien -->
				<div class="form-group row">
					<label for="klien" class="col-sm-4 col-form-label">Klien</label> 
					<div class="col-sm">
						<div class="overflow-auto container-akses">
							<?php foreach ($klien as $k) : ?>
							<div class="form-group form-check mb-2">
								<input class="form-check-input" name="klien[]" type="checkbox" value="<?= $k['id_klien'] ?>" id="<?= $k['id_klien'] ?>">
								<label class="form-check-label ml-2" for="<?= $k['id_klien'] ?>"><?= $k['nama_klien'] ?></label>
							</div>
							<?php endforeach ?>
						</div>
						<small class="form-text text-danger"><?= form_error('klien[]', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary mr-2">
                            Simpan
                        </button>
                        <a href="<?= base_url(); ?>admin/master/akses" class="btn btn-secondary mr-3"> Batal </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <!-- Judul Form -->
            <h2 align="center"><?= $judul ?></h2>
        </div>
    </div>

    <hr class="my-0">

    <!-- Isi Form -->
    <form action="" method="post"> 
        <div class="row row-child my-4">
            <div class="col">
                <div class="form-group row">
                    <div class="col">
                        <h5>Profil</h5>
                        <p class="card-subtitle text-muted"> 
                            Perbarui Profil 
                        </p>
                    </div>
                </div>
    
                <div class="row row-child">
                    <div class="col-md-12 col-lg-6">
                    
                        <!-- ID Klien -->
                        <div class="form-group row">
                            <label for="id_klien" class="col-sm-4 col-form-label">
                                ID Klien
                            </label> 
                            <div class="col-sm">
                                <input type="text" name="id_klien" class="form-control" id="id_klien" value="<?= $klien['id_klien'] ?>" readonly>
                                <small class="form-text text-danger"><?= form_error('id_klien', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- Nama Klien -->
                        <div class="form-group row">
                            <label for="nama_klien" class="col-sm-4 col-form-label">
                                Nama Klien
                            </label> 
                            <div class="col-sm">
                                <input type="text" name="nama_klien" class="form-control" id="nama_klien" value="<?= $klien['nama_klien'] ?>" required autofocus>
                                <small class="form-text text-danger"><?= form_error('nama_klien', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                        
                        <!-- Nama Usaha -->
                        <div class="form-group row">
                            <label for="nama_usaha" class="col-sm-4 col-form-label">
                                Nama Usaha
                            </label> 
                            <div class="col col-sm">
                                <input type="text" name="nama_usaha" class="form-control" id="nama_usaha" value="<?= $klien['nama_usaha'] ?>" required>
                                <small class="form-text text-danger"><?= form_error('nama_usaha', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>

                        <!-- Kode KLU -->
                        <div class="form-group row">
                            <label for="kode_klu" class="col-sm-4 col-form-label">Kode KLU</label> 
                            <div class="col col-sm">
                                <div class="input-group">
                                    <select name='kode_klu' class="selectpicker form-control" data-live-search="true" id="kode_klu" required>
                                        <option value="">-- Pilih Kode KLU --</option>
                                        <?php 
                                            $kode_input = $klien['kode_klu'];
                                            foreach ($klu as $k) : 
                                                if($k['kode_klu'] == $kode_input) {
                                        $pilih = "selected";
                                                } else {
                                        $pilih = "";
                                                }
                                        ?>
                                        <option value="<?= $k['kode_klu'] ?>" <?=$pilih;?>>
                                            <?= $k['kode_klu'] ?> - <?=$k['bentuk_usaha']?> - <?=$k['jenis_usaha']?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <small class="form-text text-danger"><?= form_error('kode_klu', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- Bentuk Usaha -->
                        <div class="form-group row">
                            <label for="bentuk_usaha" class="col-sm-4 col-form-label">Bentuk Usaha</label> 
                            <div class="col col-sm">
                                <input type="text" name="bentuk_usaha" class="form-control" id="bentuk_usaha" value="<?= $klien['bentuk_usaha'] ?>" readonly>
                            </div>
                        </div>
                    
                        <!-- Jenis Usaha -->
                        <div class="form-group row">
                            <label for="jenis_usaha" class="col-sm-4 col-form-label">Jenis Usaha</label> 
                            <div class="col col-sm">
                                <input type="text" name="jenis_usaha" class="form-control" id="jenis_usaha" value="<?= $klien['jenis_usaha'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-6">
                    
                        <!-- No. Akte Terakhir -->
                        <div class="form-group row">
                            <label for="no_akte" class="col-sm-4 col-form-label"> Nomor Akte </label> 
                            <div class="col-sm">
                                <input type="text" name="no_akte" class="form-control" id="no_akte" value="<?= $klien['no_akte'] ?>" required>
                                <small class="form-text text-danger"><?= form_error('no_akte', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- Alamat -->
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-4 col-form-label">Alamat</label> 
                            <div class="col-sm">
                                <input type="text" name="alamat" class="form-control" id="alamat" value="<?= $klien['alamat'] ?>" required>
                                <small class="form-text text-danger"><?= form_error('alamat', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- No. Telepon -->
                        <div class="form-group row">
                            <label for="telp" class="col-sm-4 col-form-label">Nomor Telepon</label> 
                            <div class="col col-sm">
                                <input type="text" name="telp" class="form-control" id="telp" value="<?= $klien['telp'] ?>" required>
                                <small class="form-text text-danger"><?= form_error('telp', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- Email -->
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email</label> 
                            <div class="col col-sm">
                                <input type="text" name="email" class="form-control" id="email" value="<?= $klien['email'] ?>" required>
                                <small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- No. HP -->
                        <div class="form-group row">
                            <label for="no_hp" class="col-sm-4 col-form-label"> No. HP </label> 
                            <div class="col col-sm">
                                <input type="text" name="no_hp" class="form-control" id="no_hp" value="<?= $klien['no_hp'] ?>">
                                <small class="form-text text-danger"><?= form_error('no_hp', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    
                        <!-- Status Pekerjaan -->
                        <div class="form-group row">
                            <label for="status_pekerjaan" class="col-sm-4 col-form-label">
                                Status Pekerjaan
                            </label> 
                            <div class="col col-sm">
                                <div class="input-group">
                                    <select name='status_pekerjaan' class="form-control" data-live-search="true" id="status_pekerjaan" required>
                                        <option value="">-- Pilih Status Pekerjaan --</option>
                                        <?php 
                                            foreach($status_pekerjaan as $stat) :
                                                if($stat == $klien['status_pekerjaan'])
                                                $pilih = 'selected';
                                                else
                                                $pilih = '';
                                        ?>
                                        <option value="<?=$stat?>" <?=$pilih?>> <?=$stat?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <small class="form-text text-danger"><?= form_error('status_pekerjaan', '<p class="mb-0">', '</p>') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="row mt-3">
                            <div class="col">
                                <h5>Pimpinan</h5>
                                <p class="card-subtitle text-muted mb-2"> 
                                    Perbarui Info Pimpinan 
                                </p>
                            </div>
                        </div>
    
                        <div class="row row-child">
                            <div class="col">
                                <!-- Nama Pimpinan -->
                                <div class="form-group row">
                                    <label for="nama_pimpinan" class="col-sm-4 col-form-label">Nama</label> 
                                    <div class="col-sm">
                                        <input type="text" name="nama_pimpinan" class="form-control" id="nama_pimpinan" value="<?= $klien['nama_pimpinan'] ?>" required>
                                        <small class="form-text text-danger"><?= form_error('nama_pimpinan', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                            
                                <!-- Jabatan -->
                                <div class="form-group row">
                                    <label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label> 
                                    <div class="col-sm">
                                        <input type="text" name="jabatan" class="form-control" id="jabatan" value="<?= $klien['jabatan'] ?>" required>
                                        <small class="form-text text-danger"><?= form_error('jabatan', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                            
                                <!-- No. HP Pimpinan -->
                                <div class="form-group row">
                                    <label for="no_hp_pimpinan" class="col-sm-4 col-form-label">
                                        No. HP
                                    </label> 
                                    <div class="col-sm">
                                        <input type="text" name="no_hp_pimpinan" class="form-control" id="no_hp_pimpinan" value="<?= $klien['no_hp_pimpinan'] ?>" required>
                                        <small class="form-text text-danger"><?= form_error('no_hp_pimpinan', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                                            
                                <!-- Email Pimpinan -->
                                <div class="form-group row">
                                    <label for="email_pimpinan" class="col-sm-4 col-form-label">
                                        Email
                                    </label> 
                                    <div class="col-sm">
                                        <input type="text" name="email_pimpinan" class="form-control" id="email_pimpinan" value="<?= $klien['email_pimpinan'] ?>">
                                        <small class="form-text text-danger"><?= form_error('email_pimpinan', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-6">
                        <div class="row mt-3">
                            <div class="col">
                                <h5>Counterpart</h5>
                                <p class="card-subtitle text-muted mb-2"> 
                                    Perbarui Info Counterpart 
                                </p>
                            </div>
                        </div>
    
                        <div class="row row-child">
                            <div class="col">
                                <!-- Nama Counterpart -->
                                <div class="form-group row">
                                    <label for="nama_counterpart" class="col-sm-4 col-form-label">Nama</label> 
                                    <div class="col-sm">
                                        <input type="text" name="nama_counterpart" class="form-control" id="nama_counterpart" value="<?= $klien['nama_counterpart'] ?>">
                                        <small class="form-text text-danger"><?= form_error('nama_counterpart', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                            
                                <!-- No. HP Counterpart -->
                                <div class="form-group row">
                                    <label for="no_hp_counterpart" class="col-sm-4 col-form-label">
                                        Nomor HP
                                    </label> 
                                    <div class="col-sm">
                                        <input type="text" name="no_hp_counterpart" class="form-control" id="no_hp_counterpart" value="<?= $klien['no_hp_counterpart'] ?>">
                                        <small class="form-text text-danger"><?= form_error('no_hp_counterpart', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                            
                                <!-- Email Counterpart -->
                                <div class="row">
                                    <label for="email_counterpart" class="col-sm-4 col-form-label">
                                        Email
                                    </label> 
                                    <div class="col-sm">
                                        <input type="text" name="email_counterpart" class="form-control" id="email_counterpart" value="<?= $klien['email_counterpart'] ?>">
                                        <small class="form-text text-danger"><?= form_error('email_counterpart', '<p class="mb-0">', '</p>') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row row-child float-right mt-3">
                    <div class="col">
                        <button type="submit" name="tambah" class="btn btn-primary">
                            Perbarui
                        </button>
                        <a href="<?= base_url(); ?>admin/klien" type="submit" name="tambah" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Untuk Memilih KLU-->
<div class="modal fade" id="modal_klu" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Pilih Kategori Lapangan Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body table-responsive">
                <table class="table table-sm table-bordered">
                    <!-- Header Table-->
                    <thead class="text-center">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Kode KLU</th>
                            <th scope="col">Bentuk Usaha</th>
                            <th scope="col">Jenis Usaha</th>
                        </tr>
                    </thead>

                    <!-- Body Table-->
                    <tbody class="text-center">
                        <!-- Looping untuk memanggil tiap data dari tabel klu-->
                        <?php foreach($klu_modal as $klu) : ?>
                        <tr>
                            <td>
                                <i class="bi bi-check-circle-fill" style="color:green" id="pilih"
                                    data-kode_klu="<?=$k['kode_klu']?>" 
                                    data-bentuk_usaha="<?=$k['bentuk_usaha']?>" 
                                    data-jenis_usaha="<?=$k['jenis_usaha']?>">
                                </i>
                            </td>
                            <td><?= $klu['kode_klu'] ?></td>
                            <td><?= $klu['bentuk_usaha'] ?></td>
                            <td><?= $klu['jenis_usaha'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?= base_url(); ?>asset/js/select2.min.js"></script>
<script>
		$('#menu1').collapse('show');

    // Script Autofill dengan Select
    $(document).on('change', '#kode_klu', function() {
		var kode = $(this).find(':selected').val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>admin/klien/pilih_klu',
            data: 'action='+ kode,
            success: function(data) {
                var json = data,
                obj = JSON.parse(json);
                $('#bentuk_usaha').val(obj.bentuk_usaha);
                $('#jenis_usaha').val(obj.jenis_usaha);
            }
        })
    });

    // Script Autofill dengan Modal
    $(document).on('click', '#pilih', function() {
        var kode_klu = $(this).data('kode_klu');
        var bentuk_usaha = $(this).data('bentuk_usaha');
        var jenis_usaha = $(this).data('jenis_usaha');

        $('#kode_klu').val(kode_klu);
        $('#bentuk_usaha').val(bentuk_usaha);
        $('#jenis_usaha').val(jenis_usaha);
        $('#modal_klu').modal('hide');
    });
</script>
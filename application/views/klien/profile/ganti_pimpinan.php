<div class="content container-fluid">
	<h3 class="mb-3"><?=$judul?></h3>
	
	<div class="card card-round card-shadow">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<form action="" method="post">
						<input type="hidden" name="tipe" value="<?=$tipe?>">
						<input type="hidden" name="table" value="<?=$table?>">
						<input type="hidden" name="id_klien" value="<?=$klien['id_klien']?>">
						
						<!-- Nama Pimpinan -->
						<div class="form-group row">
							<label for="nama_pimpinan" class="col-lg-3 col-form-label">Nama</label> 
							<div class="col-lg">
								<input type="text" name="nama_pimpinan" class="form-control" id="nama_pimpinan" value="<?= $klien['nama_pimpinan'] ?>" required>
								<small class="form-text text-danger"><?= form_error('nama_pimpinan', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- Jabatan -->
						<div class="form-group row">
							<label for="jabatan" class="col-lg-3 col-form-label">Jabatan</label> 
							<div class="col-lg">
								<input type="text" name="jabatan" class="form-control" id="jabatan" value="<?= $klien['jabatan'] ?>" required>
								<small class="form-text text-danger"><?= form_error('jabatan', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<!-- No. HP Pimpinan -->
						<div class="form-group row">
							<label for="no_hp_pimpinan" class="col-lg-3 col-form-label">
								No. HP
							</label> 
							<div class="col-lg">
								<input type="text" name="no_hp_pimpinan" class="form-control" id="no_hp_pimpinan" value="<?= $klien['no_hp_pimpinan'] ?>" required>
								<small class="form-text text-danger"><?= form_error('no_hp_pimpinan', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>

						<!-- Email Pimpinan -->
						<div class="form-group row">
							<label for="email_pimpinan" class="col-lg-3 col-form-label">
								Email
							</label> 
							<div class="col-lg">
								<input type="text" name="email_pimpinan" class="form-control" id="email_pimpinan" value="<?= $klien['email_pimpinan'] ?>">
								<small class="form-text text-danger"><?= form_error('email_pimpinan', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Perbarui</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script> 
	$(document).on('change', '#kode_klu', function() {
		var kode = $(this).find(':selected').val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url(); ?>admin/master/klien/pilih_klu',
			data: 'action='+ kode,
			success: function(data) {
				var json = data,
				obj = JSON.parse(json);
				$('#bentuk_usaha').val(obj.bentuk_usaha);
				$('#jenis_usaha').val(obj.jenis_usaha);
			}
		})
	});
</script>
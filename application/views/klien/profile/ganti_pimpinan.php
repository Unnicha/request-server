<div class="container-fluid">
	<div class="row px-3">
		<div class="col">
			<h3>Ubah Info Pimpinan</h3>
		</div>
	</div>
	
	<hr class="my-0">
	
	<form action="" method="post">
		<div class="row row-child mt-3">
			<div class="col col-tambah">
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
		
		<hr class="my-0">
		
		<div class="row row-child m-3">
			<div class="col">
				<button type="submit" name="tambah" class="btn btn-primary">Perbarui</button>
				<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
			</div>
		</div>
	</form>
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
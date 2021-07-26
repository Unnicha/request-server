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
				<div class="form-group row">
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
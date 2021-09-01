<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
	</div>
	
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
	
	<div class="row">
		<div class="col">
			<div class="card card-round">
				<div class="card-body p-4">
					<form action="" method="post">
						<!-- Tahun -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Tahun Akses</label>
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
							<label class="col-sm-4 col-form-label">Bulan Mulai</label>
							<div class="col-sm">
								<select name="masa" class="form-control" id="masa" required>
									<?php
										foreach($masa as $m) :
											if($m['id_bulan'] == date('m')) { $pilih = "selected"; }
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
						
						<!-- ID Akuntan -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Nama Akuntan</label>
							<div class="col-sm">
								<select name="id_akuntan" class="form-control" id="id_akuntan" required>
								</select>
								<small class="form-text text-danger"><?= form_error('id_akuntan', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Akses -->
						<div class="form-group row">
							<label for="akuntansi" class="col-sm-4 col-form-label">
								<b>Akses Data Klien</b>
							</label>
						</div>
		
						<!-- Data Akuntansi -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Data Akuntansi</label>
							<div class="col-sm">
								<select name='akuntansi[]' class="form-control select-multiple" multiple="multiple" required>
									<?php foreach ($klien as $k) : ?>
									<option value="<?= $k['id_klien'] ?>"><?= $k['nama_klien'] ?></option>
									<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('akuntansi[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Data Perpajakan -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Data Perpajakan</label>
							<div class="col-sm">
								<div class="input-group">
									<select name='perpajakan[]' class="form-control select-multiple" multiple="multiple" required>
										<?php foreach ($klien as $k) : ?>
										<option value="<?= $k['id_klien'] ?>"><?= $k['nama_klien'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('perpajakan[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Data Lainnya -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Data Lainnya</label>
							<div class="col-sm">
								<div class="input-group">
									<select name='lainnya[]' class="form-control select-multiple" multiple="multiple" required>
										<?php foreach ($klien as $k) : ?>
										<option value="<?= $k['id_klien'] ?>"><?= $k['nama_klien'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('lainnya[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<div class="row mt-4">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary"> Batal </a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('.select-multiple').select2({
			placeholder: '--Tambahkan Klien--'
		});
		
		function getAkuntan() {
			$.ajax({
				type	: 'POST',
				url		: '<?=base_url()?>admin/master/akses/akuntan',
				data	: 'tahun=' +$('#tahun').val(),
				success	: function(e) {
					$('#id_akuntan').html(e);
				}
			})
		}
		getAkuntan();
		
		$('#tahun').change(function() {
			getAkuntan();
		})
	});
</script>

<div class="content container-fluid">
	<div class="card card-round card-shadow">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="row mb-4 text-center">
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
					
					<form action="" method="post">
						<!-- Klien -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">Nama Klien</label>
							<div class="col-sm">
								<select name="id_klien" class="form-control" id="id_klien" required>
									<option value="">--Pilih Klien--</option>
								</select>
								<small class="form-text text-danger"><?= form_error('id_klien', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Tahun -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">Tahun Akses</label>
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
							<label class="col-md-3 col-form-label">Bulan Mulai</label>
							<div class="col-sm">
								<select name="masa" class="form-control" id="masa" required>
									<option value="">--Pilih Bulan--</option>
									<?php foreach($masa as $m) : ?>
									<option value="<?=$m['id_bulan']?>"><?=$m['nama_bulan']?></option>
									<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('masa', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Akses -->
						<div class="form-group row">
							<label for="akuntansi" class="col col-form-label">
								<b>Penanggung jawab</b>
							</label>
						</div>
		
						<!-- Data Akuntansi -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">PJ Akuntansi</label>
							<div class="col-sm">
								<select name='akuntansi[]' class="form-control select-multiple" multiple="multiple" required>
									<?php foreach ($akuntan as $k) : ?>
									<option value="<?= $k['id_user'] ?>"><?= $k['nama'] ?></option>
									<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('akuntansi[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Data Perpajakan -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">PJ Perpajakan</label>
							<div class="col-sm">
								<div class="input-group">
									<select name='perpajakan[]' class="form-control select-multiple" multiple="multiple" required>
										<?php foreach ($akuntan as $k) : ?>
										<option value="<?= $k['id_user'] ?>"><?= $k['nama'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('perpajakan[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Data Lainnya -->
						<div class="form-group row">
							<label class="col-md-3 col-form-label">PJ Lainnya</label>
							<div class="col-sm">
								<div class="input-group">
									<select name='lainnya[]' class="form-control select-multiple" multiple="multiple" required>
										<?php foreach ($akuntan as $k) : ?>
										<option value="<?= $k['id_user'] ?>"><?= $k['nama'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<small class="form-text text-danger"><?= form_error('lainnya[]', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<div class="row mt-4 text-right">
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
			placeholder: '--Pilih Akuntan--'
		});
		
		function getAkuntan() {
			$.ajax({
				type	: 'POST',
				url		: '<?=base_url()?>admin/master/akses/getKlien',
				data	: 'tahun=' +$('#tahun').val(),
				success	: function(e) {
					$('#id_klien').html(e);
				}
			})
		}
		getAkuntan();
		
		$('#tahun').change(function() {
			getAkuntan();
		})
	});
</script>

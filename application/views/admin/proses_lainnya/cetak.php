<div class="container-fluid">
	<div class="row row-child mt-3">
		<div class="col">
			<h3><?= $judul; ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child my-4">
		<div class="col col-tambah">
			<form action="" method="post" target="_blank"> 
				<input type="hidden" id="level" name="level" value="<?=$this->session->userdata('level')?>">
				<input type="hidden" id="id_user" name="id_user" value="<?=$this->session->userdata('id_user')?>">
				
				<!-- Masa -->
				<div class="form-group row">
					<label for="masa" class="col-sm-4 col-form-label">Masa</label> 
					<div class="col-sm">
						<select name='masa' class="form-control" id="masa" required>
							<?php 
								$bulan = date('m');
								foreach ($masa as $m) : 
									if ($m['id'] == $bulan) 
									$pilih="selected";
									else
									$pilih="";
							?>
							<option <?=$pilih?>> <?= $m['value'] ?> </option>
							<?php endforeach ?>
						</select>
						<small class="form-text text-danger"><?= form_error('masa', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<!-- Tahun -->
				<div class="form-group row">
					<label for="tahun" class="col-sm-4 col-form-label">Tahun</label> 
					<div class="col-sm">
						<select name='tahun' class="form-control" id="tahun" required>
							<?php 
								$now = date('Y');
								for ($i=$now; $i>=2010; $i--) : ?>
							<option><?= $i; ?></option>
								<?php endfor; ?>
						</select>
						<small class="form-text text-danger"><?= form_error('tahun', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!--  -->
				<div class="form-group row">
					<label for="tampil" class="col-sm-4 col-form-label">Berdasarkan</label> 
					<div class="col-sm">
						<select name='tampil' class="form-control" id="tampil" required>
							<option>Klien</option>
							<option>Akuntan</option>
						</select>
						<small class="form-text text-danger"><?= form_error('tampil', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<!-- Klien -->
				<div class="form-group row">
					<label for="pilih" class="col-sm-4 col-form-label">Pilih</label> 
					<div class="col-sm">
						<select name='pilih' class="form-control" id="pilih">
							<option value="">--Pilih--</option>
						</select>
					</div>
				</div>
				
				<!-- Tombol Simpan -->
				<div class="row mt-5">
					<div class="col">
						<button type="submit" name="xls" class="btn btn-primary mr-1">
							Export Excel 
						</button>
						<button type="submit" name="pdf" class="btn btn-info mr-1">
							Export PDF 
						</button>
						<a href="<?= base_url(); ?>admin/proses/proses_data_akuntansi" class="btn btn-secondary">
							Batal
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		
		function berdasarkan(jenis) {
			$.ajax({
				type : 'POST',
				url : '<?=base_url()?>admin/proses/proses_data_akuntansi/ganti_tampil',
				data : {jenis : jenis},
				success : function(data) {
					$('#pilih').html(data);
				}
			})
		}
		var jenis = $('#tampil').find(':selected').val();
		berdasarkan(jenis);

		$('#tampil').change(function() {
			var jenis = $(this).find(':selected').val();
			berdasarkan(jenis);
		})
	})
</script>
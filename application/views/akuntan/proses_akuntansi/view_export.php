<div class="container">
	<h5 class="px-4 mb-3"><?= $judul ?></h5>

	<div class="row">
		<div class="col col-proses">
			<form action="<?=base_url('akuntan/proses_data_akuntansi/download')?>" method="post" > 
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
					</div>
				</div>
				
				<div class="form-group row">
					<label for="masa" class="col-sm-4 col-form-label">Bulan</label> 
					<div class="col-sm">
						<select name='masa' class="form-control" id="masa" required>
							<?php 
								$bulan = date('m');
								foreach ($masa as $m) : 
									$pilih = ($m['id_bulan'] == $bulan) ? "selected" : "";
							?>
							<option value="<?= $m['id_bulan'] ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="klien" class="col-sm-4 col-form-label">Klien</label> 
					<div class="col-sm">
						<select name='klien' class="form-control" id="klien">
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<a href="#" class="btn btn-primary float-right cek">Cek Data</a>
					</div>
				</div>
				
				<div class="row mt-3 export">
					<div class="col export-alert">
					</div>
				</div>
				<div class="row export">
					<div class="col export-button">
						<button type="submit" name="export" value="xls" class="btn btn-success">Export Excel</button>
						<button type="submit" name="export" value="pdf" class="btn btn-danger">Export PDF</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		function ganti() {
			$('.export').hide();
			$('.export-button').hide();
		}
		ganti();
		
		function getKlien() {
			$.ajax({
				type	: 'POST',
				url		: '<?=base_url()?>akuntan/proses_data_akuntansi/gantiKlien',
				data	: {
					bulan	: $('#masa').val(),
					tahun	: $('#tahun').val(),
					},
				success	: function(e) {
					$('#klien').html(e);
				}
			})
		}
		getKlien();
		
		$('#masa').change(function() {
			getKlien();
			ganti();
		});
		$('#tahun').change(function() {
			getKlien();
			ganti();
		});
		$('#klien').change(function() {
			ganti();
		});
		
		$('.cek').click(function() {
			$.ajax({
				type	: 'POST',
				url		: '<?=base_url()?>akuntan/proses_data_akuntansi/cek_proses',
				data	: {
					bulan	: $('#masa').val(),
					tahun	: $('#tahun').val(),
					klien	: $('#klien').val(),
					},
				success	: function(e) {
					var data = JSON.parse(e);
					$('.export').show();
					$('.export-alert').html(data.alert);
					if(data.button == 'ok') {
						$('.export-button').show();
					}
				}
			})
		})
	})
</script>
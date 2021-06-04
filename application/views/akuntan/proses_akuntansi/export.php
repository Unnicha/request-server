<div class="container">
	<h5 class="px-4 my-3"><?= $judul ?></h5>

	<div class="row">
		<div class="col">
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
									if ($m['id_bulan'] == $bulan) 
									$pilih="selected";
									else
									$pilih="";
							?>
							<option <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
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
				
				<div class="row mt-4">
					<div class="col">
						<button type="submit" name="export" value="xls" class="btn btn-primary">
							Export Excel 
						</button>
						<button type="submit" name="export" value="pdf" class="btn btn-info">
							Export PDF 
						</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
							Batal
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
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
		});
		$('#tahun').change(function() {
			getKlien();
		});
		
	})
</script>
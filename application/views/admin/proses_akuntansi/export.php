<div class="modal-header">
	<h5 class="modal-title"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container p-0">
		<tbody>
			<form action="<?=base_url('admin/proses/proses_data_akuntansi/download')?>" method="post" > 
				<input type="hidden" id="level" name="level" value="<?=$this->session->userdata('level')?>">
				<input type="hidden" id="id_user" name="id_user" value="<?=$this->session->userdata('id_user')?>">
				
				<div class="form-group row">
					<label for="tampil_export" class="col-sm-4 col-form-label">Berdasarkan</label> 
					<div class="col-sm">
						<select name='tampil_export' class="form-control" id="tampil_export" required>
							<option>Klien</option>
							<option>Akuntan</option>
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="akuntan_export" class="col-sm-4 col-form-label">Akuntan</label> 
					<div class="col-sm">
						<select name='akuntan_export' class="form-control" id="akuntan_export" required>
						</select>
					</div>
				</div>
				
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
				
				<div class="row mt-5">
					<div class="col">
						<button type="submit" name="xls" class="btn btn-primary">
							Export Excel 
						</button>
						<button type="submit" name="pdf" class="btn btn-info">
							Export PDF 
						</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
							Batal
						</button>
					</div>
				</div>
			</form>
		</tbody>
	</div>
</div>

<script>
	$(document).ready(function() {
		function getAkuntan() {
			$.ajax({
				type	: 'POST',
				data	: { tampil : $('#tampil_export').val() },
				url		: '<?=base_url()?>admin/proses/proses_data_akuntansi/gantiTampilan',
				success	: function(e) {
					$('#akuntan_export').html(e);
				}
			})
		}
		function getKlien() {
			$.ajax({
				type	: 'POST',
				data	: {
					tampil	: $('#tampil_export').val(),
					akuntan	: $('#akuntan_export').val(),
					bulan	: $('#masa').val(),
					tahun	: $('#tahun').val(),
					},
				url		: '<?=base_url()?>admin/proses/proses_data_akuntansi/gantiKlien',
				success	: function(e) {
					$('#klien').html(e);
				}
			})
		}
		getAkuntan();
		getKlien();

		$('#tampil_export').change(function() {
			getAkuntan();
			getKlien();
		});
		$('#akuntan_export').change(function() {
			getKlien();
		});
		$('#masa').change(function() {
			getKlien();
		});
		$('#tahun').change(function() {
			getKlien();
		});
		
	})
</script>
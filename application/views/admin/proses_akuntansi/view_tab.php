<div class="container-fluid">
	
	<!-- Judul -->
	<h2 class="text-center mb-2"> <?= $header; ?> </h2>

	<?php if($this->session->flashdata('flash')) : ?>
	<div class="row">
		<div class="col">
			<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
				Data <strong>Berhasil</strong> <?= $this->session->flashdata('flash'); ?>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- Form Ganti Tampilan -->
	<form action="" method="post">
		<div class="form-group row form-inline">
			<div class="col-3 form-inline">
				<label for="tampil" class="px-2">Tampil</label>
				<select name="bulan" class="form-control" id="tampil">
					<option value="Akuntan">Akuntan</option>
					<option value="Klien">Klien</option>
				</select>
			</div>
			
			<div class="col text-right">
				<!-- Ganti Bulan -->
				<select name="bulan" class="form-control" id="bulan">
					<?php 
						$bulan = date('m');
						$sess_bulan = $this->session->userdata('bulan');
						if($sess_bulan) {$bulan = $sess_bulan;}
	
						foreach ($masa as $m) : 
							if ($m['id'] == $bulan || $m['value'] == $bulan) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
					?>
					<option value="<?= $m['value']; ?>" <?=$pilih?>> <?= $m['value'] ?> </option>
					<?php endforeach ?>
				</select>
				
				<!-- Ganti Tahun -->
				<select name="tahun" class="form-control" id="tahun">
					<?php 
						$tahun = date('Y');
						$sess_tahun = $this->session->userdata('tahun');
						for($i=$tahun; $i>=2010; $i--) :
							if ($i == $sess_tahun) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
					?>
					<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
					<?php endfor ?>
				</select>

				<!-- Ganti Klien -->
				<select name="klien" class="form-control" id="klien">
					<option value="">--Tidak Ada Klien--</option>
				</select> 
				
			</div>
		</div>
	</form>
	
	<div id="show">
		<!-- Isi Table -->
	</div>
</div>

<script>
	$(document).ready(function() {

		function akses(){
			var jenis = $('#tampil').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses_data_akuntansi/ganti_tampil',
				data: {'jenis':jenis},
				success: function(data) {
					$("#klien").html(data);
				}
			})
		}
		
		function tampil(){
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();
			var klien = $('#klien').val();
			var jenis = $('#tampil').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses_data_akuntansi/ganti',
				data: {
					'bulan': bulan, 
					'tahun': tahun, 
					'klien': klien, 
					'jenis': jenis,
					},
				//dataType: 'json', => karna datanya ga diencode ke json jadi 'dataType' jangan dideclare
				success: function(data) {
					$("#show").html(data);
				}
			})
		}

		akses();
		tampil();

		$("#tampil").change(function() {
			akses();
			tampil();
		});

		$("#bulan").change(function() {
			tampil();
		});
		
		$("#tahun").change(function() {
			tampil();
		});

		$("#klien").change(function() {
			tampil();
		})
	});
</script>
<!--
-->
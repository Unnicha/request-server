<div class="container-fluid">

	<!-- Judul -->
	<h2 class="mb-3" align="center"> <?= $header; ?> </h2>
	
	<div class="row">
		<div class="col">
			<div class="row form-group form-inline">
				<div class="col">
				
					<!-- Ganti Bulan -->
					<select name='bulan' class="form-control" id="bulan">
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
					<select name='tahun' class="form-control" id="tahun">
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
					<select name='klien' class="form-control" id="klien">
						<option value=""> Semua Klien </option>
						<?php 
						$sess_klien = $this->session->flashdata('klien');
						foreach ($klien as $k) :
							if ($k['id_klien'] == $sess_klien) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
						?>
						<option value="<?= $k['id_klien']; ?>" <?= $pilih; ?>> 
						<?= $k['nama_klien'] ?> 
						</option>
						<?php endforeach ?>
					</select> 
				</div>
			</div>
		</div>
	</div>
	
	<div id="show">
		<!-- Isi Table -->
	</div>
</div>


<script>
		$(document).ready(function() {

			function tampil() {
				var klien = $('#klien').val();
				var bulan = $('#bulan').val();
				var tahun = $('#tahun').val();
				$.ajax({
					type: 'POST',
					url: '<?= base_url(); ?>akuntan/penerimaan_data_perpajakan/ganti',
					data: {'klien': klien, 'bulan':bulan, 'tahun': tahun},
					success: function(data) {
						$("#show").html(data);
					}
				})
			}
			function klien() {
				var bulan = $('#bulan').val();
				var tahun = $('#tahun').val();
				$.ajax({
					type: 'POST',
					url: '<?= base_url(); ?>akuntan/penerimaan_data_perpajakan/klien',
					data: {'bulan':bulan, 'tahun': tahun},
					success: function(data) {
						$("#klien").html(data);
					}
				})
			}
			klien();
			tampil();

			$("#bulan").change(function() {
				klien();
				tampil();
			});

			$("#tahun").change(function() {
				klien();
				tampil();
			});

			$("#klien").change(function() {
				tampil();
			});
		});
</script>
<!--
-->

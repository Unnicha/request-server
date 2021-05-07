<div class="container-fluid"> 

	<!-- Judul Table-->
	<h2 class="mb-4" align="center"> <?= $judul; ?> </h2>
	 
	<!-- Form Ganti Isi Tabel -->
	<form action="<?=base_url()?>admin/penerimaan_data_perpajakan/cetak" method="post" target="_blank">
		<div class="form-group row form-inline">
			<div class="col-12 col-sm">
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
						$sess_klien = $this->session->userdata('klien');
						foreach ($klien as $k) :
							if ($k['id_klien'] == $sess_klien) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
						?>
					<option value="<?= $k['id_klien']; ?>" <?= $pilih; ?>><?= $k['nama_klien'] ?></option>
						<?php endforeach ?>
				</select> 
			</div>
				
			<div class="col-12 col-sm-4 col-lg-3">
				<div class="row float-sm-right pr-3">
					<button type="submit" name="xls" class="btn btn-success mr-1">
						<i class="bi bi-download"></i>
						Excel
					</button>
					<button type="submit" name="pdf" class="btn btn-danger">
						<i class="bi bi-download"></i>
						PDF
					</button>
				</div>
			</div>
		</div>
	</form>
	
	<div id="show">
		<!-- Isi Table -->
	</div>
</div>


<script>
	$(document).ready(function() {
		$('#menu3').collapse('show');

		function ganti() {
			var klien = $('#klien').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/penerimaan_data_perpajakan/ganti',
				data: {'bulan':bulan, 'klien': klien, 'tahun': tahun},
				success: function(data) {
					$("#show").html(data);
				}
			})
		}
		ganti();
		
		$("#klien").change(function() { 
			ganti();
		})
		$("#bulan").change(function() { 
			ganti();
		})
		$("#tahun").change(function() { 
			ganti();
		})
	});
</script>
<!--
-->

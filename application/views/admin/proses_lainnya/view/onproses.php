<div class="container-fluid">
	
	<!-- Judul -->
	<h2 class="text-center mb-2"> <?= $header; ?> </h2>
 
	<!-- Form Ganti Tampilan -->
	<form action="<?=base_url()?>admin/proses_data_lainnya/download" method="post" target="_blank">
		<div class="form-group row">
			<div class="col form-inline">
				<!-- Ganti Bulan -->
				<select name="bulan" class="form-control mr-1" id="bulan_proses">
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
				<select name="tahun" class="form-control mr-1" id="tahun_proses">
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
				
				<select name="tampil" class="form-control mr-1" id="tampil_proses">
					<option value="Klien">Klien</option>
					<option value="Akuntan">Akuntan</option>
				</select>

				<!-- Ganti Klien -->
				<select name="klien" class="form-control mr-1" id="klien_proses">
					<option value="">--Tidak Ada Klien--</option>
				</select> 
			</div>

			<div class="col-2 pl-0">
				<div class="dropdown float-right">
					<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Export
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						<button type="submit" id="xls" name="xls" class="dropdown-item">Export Excel</button>
						<button type="submit" id="pdf" name="pdf" class="dropdown-item">Export PDF</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<div id="show_proses">
		<!-- Isi Table -->
	</div>
</div>

<script>
	$(document).ready(function() {

		function akses(){
			var jenis = $('#tampil_proses').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses_data_lainnya/ganti_tampil',
				data: {'jenis':jenis},
				success: function(data) {
					$("#klien_proses").html(data);
				}
			})
		}
		
		function tampil(){
			var bulan = $('#bulan_proses').val();
			var tahun = $('#tahun_proses').val();
			var klien = $('#klien_proses').val();
			var jenis = $('#tampil_proses').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses_data_lainnya/ganti',
				data: {
					'bulan': bulan, 
					'tahun': tahun, 
					'klien': klien, 
					'jenis': jenis,
					},
				//dataType: 'json', => karna datanya ga diencode ke json jadi 'dataType' jangan dideclare
				success: function(data) {
					$("#show_proses").html(data);
				}
			})
		}

		akses();
		tampil();

		$("#tampil_proses").change(function() {
			akses();
			tampil();
		});

		$("#bulan_proses").change(function() {
			tampil();
		});
		
		$("#tahun_proses").change(function() {
			tampil();
		});

		$("#klien_proses").change(function() {
			tampil();
		})
	});
</script>
<!--
-->
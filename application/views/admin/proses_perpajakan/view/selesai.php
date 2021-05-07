<div class="container-fluid">
	
	<!-- Judul -->
	<h2 class="text-center mb-2"> <?= $header; ?> </h2>
 
	<!-- Form Ganti Tampilan -->
	<form action="<?=base_url()?>admin/proses_data_perpajakan/download" method="post" target="_blank">
		<div class="form-group row">
			<div class="col form-inline">
				<!-- Ganti Bulan -->
				<select name="bulan" class="form-control mr-1" id="bulan_selesai">
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
				<select name="tahun" class="form-control mr-1" id="tahun_selesai">
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
				
				<select name="tampil" class="form-control mr-1" id="tampil_selesai">
					<option value="Klien">Klien</option>
					<option value="Akuntan">Akuntan</option>
				</select>

				<!-- Ganti Klien -->
				<select name="klien" class="form-control mr-1" id="klien_selesai">
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
	
	<div id="show_selesai">
		<!-- Isi Table -->
	</div>
</div>

<script>
	$(document).ready(function() {

		function akses(){
			var jenis = $('#tampil_selesai').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses_data_perpajakan/ganti_tampil',
				data: {'jenis':jenis},
				success: function(data) {
					$("#klien_selesai").html(data);
				}
			})
		}
		
		function tampil(){
			var bulan = $('#bulan_selesai').val();
			var tahun = $('#tahun_selesai').val();
			var klien = $('#klien_selesai').val();
			var jenis = $('#tampil_selesai').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses_data_perpajakan/ganti',
				data: {
					'bulan': bulan, 
					'tahun': tahun, 
					'klien': klien, 
					'jenis': jenis,
					},
				//dataType: 'json', => karna datanya ga diencode ke json jadi 'dataType' jangan dideclare
				success: function(data) {
					$("#show_selesai").html(data);
				}
			})
		}

		akses();
		tampil();

		$("#tampil_selesai").change(function() {
			akses();
			tampil();
		});

		$("#bulan_selesai").change(function() {
			tampil();
		});
		
		$("#tahun_selesai").change(function() {
			tampil();
		});

		$("#klien_selesai").change(function() {
			tampil();
		})
	});
</script>
<!--
-->
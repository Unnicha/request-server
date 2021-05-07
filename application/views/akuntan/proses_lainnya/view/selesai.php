<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<!-- Judul -->
	<h2 class="text-center mb-0 py-3"> <?= $header; ?> </h2>

	<div class="row">
		<!-- Form Ganti Tampilan -->
		<div class="col col-sm">
			<form action="" method="post">
				<div class="form-group row form-inline">
					<div class="col">
					
					<!-- Ganti Bulan -->
					<select name="bulan" class="form-control" id="bulan_selesai">
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
					<select name="tahun" class="form-control" id="tahun_selesai">
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
					<select name="klien" class="form-control" id="klien_selesai">
						<option value=""> Tidak Ada Klien </option>
					</select> 
					
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div id="show_selesai">
		<!-- Isi Table -->
	</div>
</div>

<script>
	$(document).ready(function() {

		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		function ganti_akses(){
			var bulan = $('#bulan_selesai').val();
			var tahun = $('#tahun_selesai').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/proses_data_lainnya/ganti_akses',
				data: {'bulan':bulan, 'tahun': tahun},
				dataType: 'json',
				success: function(data) {
					$("#klien_selesai").html(data);
				}
			})
		}
		
		function tampil(){
			var bulan = $('#bulan_selesai').val();
			var tahun = $('#tahun_selesai').val();
			var klien = $('#klien_selesai').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/proses_data_lainnya/ganti',
				data: {'bulan':bulan, 'tahun': tahun, 'klien':klien},
				//dataType: 'json', => karna datanya ga diencode ke json jadi 'dataType' jangan dideclare
				success: function(data) {
					$("#show_selesai").html(data);
				}
			})
		} 
		ganti_akses();
		tampil();

		$("#bulan_selesai").change(function() { 
			ganti_akses();
			tampil();
		});

		$("#tahun_selesai").change(function() { 
			ganti_akses();
			tampil();
		});

		$("#klien_selesai").change(function() { 
			tampil();
		});
	});
</script>
<!--
-->
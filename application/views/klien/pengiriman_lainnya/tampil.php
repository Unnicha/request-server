<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<!-- Judul -->
	<h2 class="text-center"> <?= $judul; ?> </h2>

	<div class="row"> 
		<!-- Kolom untuk mengganti masa/bulan -->
		<div class="col col-sm">
			<form action="" method="post">
				<div class="form-group row form-inline"> 
					<!-- Ganti Bulan -->
					<select name='bulan' class="form-control ml-3" id="bulan">
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
					<select name='tahun' class="form-control ml-2" id="tahun">
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
				</div>
			</form>
		</div> 
	</div>
	
	<div id="show">
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
		
		function tampil() {
		var bulan = $('#bulan').find(':selected').val();
		var tahun = $('#tahun').find(':selected').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>klien/pengiriman_data_lainnya/isi',
				data: {bulan: bulan, tahun: tahun,},
				success: function(data) {
					$("#show").html(data);
				}
			})
		} 
		tampil();

		$("#bulan").change(function() { 
			tampil();
		});
		
		$("#tahun").change(function() { 
			tampil();
		});
	});
</script>
<!--
-->
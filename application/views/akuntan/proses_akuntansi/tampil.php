<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="mb-3" align=center><?=$judul?></h2>
	
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-belum" data-toggle="tab" data-nilai="belum" href="#belum" role="tab" aria-controls="belum" aria-selected="false" style="color:black">Belum Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link active" id="tab-onproses" data-toggle="tab" data-nilai="onproses" href="#onproses" role="tab" aria-controls="onproses" aria-selected="true" style="color:black">Sedang Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-selesai" data-toggle="tab" data-nilai="selesai" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false" style="color:black">Selesai Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-export" data-toggle="tab" data-nilai="export" href="#export" role="tab" aria-controls="export" aria-selected="false" style="color:black">Export</a>
		</li>
	</ul>
	
	<div class="tab-content container-proses py-3 mb-3" id="myTabContent">
		<div class="tab-pane fade" id="belum" role="tabpanel" aria-labelledby="tab-belum">belum</div>
		<div class="tab-pane fade show active" id="onproses" role="tabpanel" aria-labelledby="tab-onproses">onproses</div>
		<div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="tab-selesai">selesai</div>
		<div class="tab-pane fade" id="export" role="tabpanel" aria-labelledby="tab-export">export</div>
	</div>
</div>


<!-- Detail Proses -->
<div class="modal fade detailProses" tabindex="-1" aria-labelledby="detailProsesLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content profile-klien showProses">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		function view(status) {
			$.ajax({
				type: 'POST',
				data: {
					status	: status,
					},
				url: '<?= base_url(); ?>akuntan/proses_data_akuntansi/prosesOn',
				success: function(data) {
					$('#'+status).html(data);
				}
			})
		}
		view( $('#myTab li a.active').data('nilai') );
		
		$('#tab-onproses').click(function() {
			view ($(this).data('nilai') );
		});
		$('#tab-belum').click(function() {
			view ($(this).data('nilai') );
		});
		$('#tab-selesai').click(function() {
			view ($(this).data('nilai') );
		});

		$('#tab-export').click(function() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>akuntan/proses_data_akuntansi/export',
				success	: function(data) {
					$('#export').html(data);
				}
			})
		})
	});
</script>

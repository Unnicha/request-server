<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="mb-3" align=center><?=$judul?></h2>
	<?php $status = @$_GET['p']; ?>
	
	<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='belum') ? 'active' : '' ?> px-0" href="<?=$link?>?p=belum" id="belum" style="color:black">
				Belum Diproses
			</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='onproses' || $status=='') ? 'active' : '' ?> px-0" href="<?=$link?>?p=onproses" id="onproses" style="color:black">
				Sedang Diproses
			</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='selesai') ? 'active' : '' ?> px-0" href="<?=$link?>?p=selesai" id="selesai" style="color:black">
				Selesai Diproses
			</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='export') ? 'active' : '' ?> px-0" href="<?=$link?>?p=export" id="export" style="color:black">
				Export
			</a>
		</li>
	</ul>
	
	<div class="tab-content container-proses py-3 mb-3" id="myTabContent">
		<div class="tab-pane fade show active"></div>
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
		
		function view() {
			$.ajax({
				type	: 'POST',
				data	: 'tab='+$('.nav-link.active').attr('id'),
				url		: '<?= base_url(); ?>akuntan/proses_data_akuntansi/prosesOn',
				success	: function(data) {
					$('.tab-pane').html(data);
				}
			})
		}
		view();
	});
</script>

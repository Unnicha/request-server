<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<h2 class="mb-3" align=center><?=$judul?></h2>
	<?php $status = @$_GET['p']; ?>

	<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='belum') ? 'active' : '' ?>" href="<?=$link?>?p=belum" id="belum" style="color:black">
				Belum Diproses
			</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='onproses' || $status=='') ? 'active' : '' ?>" href="<?=$link?>?p=onproses" id="onproses" style="color:black">
				Sedang Diproses
			</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='selesai') ? 'active' : '' ?>" href="<?=$link?>?p=selesai" id="selesai" style="color:black">
				Selesai Diproses
			</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link <?= ($status=='export') ? 'active' : '' ?>" href="<?=$link?>?p=export" id="export" style="color:black">
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

<!-- Batalkan Proses -->
<div class="modal fade batalProses" tabindex="-1" aria-labelledby="batalProsesLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" style="width:400px">
			<div class="modal-header pl-4">
				<h5 class="modal-title">Batalkan Proses</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-3">
				<div class="row mb-4">
					<div class="col">
						<font size="4">
							Apakah Anda akan membatalkan proses data <mark class="idProses"></mark> ?
						</font>
					</div>
				</div>
				<div class="row text-center">
					<div class="col">
						<a class="btn btn-outline-secondary cancel" data-dismiss="modal" aria-label="Close">
							Kembali
						</a>
						<a class="btn btn-danger showBatalProses">
							Batalkan
						</a>
					</div>
				</div>
			</div>
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
				url		: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/prosesOn',
				success	: function(data) {
					$('.tab-pane').html(data);
				}
			})
		}
		view();

		// Batal
		$('.showBatalProses').click(function() {
			var id		= $('.idProses').html();
			var status	= $('#myTab li a.active').data('nilai');
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/batal',
				data	: 'id=' +id,
				success	: function() {
					$('.batalProses').modal('hide');
					window.location.assign("<?= base_url();?>admin/proses/proses_data_perpajakan");
				}
			})
		});

		// EXPORT
		$('.btn-export').on('click', function() {
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/export',
				success: function(data) {
					$(".detailProses").modal('show');
					$(".showProses").html(data);
				}
			})
		});
	});
</script>

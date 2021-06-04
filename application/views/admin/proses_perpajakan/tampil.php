<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<h2 class="mb-2" align=center><?=$judul?></h2>

	<div class="row mb-3">
		<div class="col form-inline">
			<label>Tampilan per</label>
			<select name="tampil" class="form-control ml-2" id="tampil">
				<option>Klien</option>
				<option>Akuntan</option>
			</select>
			<select name="akuntan" class="form-control ml-2" id="akuntan">
			</select>
		</div>
		<div class="col-3 text-right">
			<button class="btn btn-primary btn-export">Export</button>
		</div>
	</div>

	<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-belum" data-toggle="tab" data-nilai="belum" href="#belum" role="tab" aria-controls="belum" aria-selected="false" style="color:black">Belum Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link active" id="tab-onproses" data-toggle="tab" data-nilai="onproses" href="#onproses" role="tab" aria-controls="onproses" aria-selected="true" style="color:black">Sedang Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-selesai" data-toggle="tab" data-nilai="selesai" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false" style="color:black">Selesai Diproses</a>
		</li>
	</ul>


	<div class="tab-content container-proses py-3 mb-3" id="myTabContent">
		<div class="tab-pane fade" id="belum" role="tabpanel" aria-labelledby="tab-belum">belum</div>
		<div class="tab-pane fade show active" id="onproses" role="tabpanel" aria-labelledby="tab-onproses">onproses</div>
		<div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="tab-selesai">selesai</div>
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

		function tampilan() {
			$.ajax({
				type	: 'POST',
				data	: { tampil : $('#tampil').val() },
				url		: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/gantiTampilan',
				success	: function(data) {
					$("#akuntan").html(data);
				}
			})
		}
		function view(status) {
			$.ajax({
				type: 'POST',
				data: {
					status	: status,
					tampil	: $('#tampil').val(),
					akuntan	: $('#akuntan').val(),
					},
				url: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/prosesOn',
				success: function(data) {
					$('#'+status).html(data);
				}
			})
		}
		tampilan();
		view( $('#myTab li a.active').data('nilai') );

		$('#tampil').on('change', function() {
			tampilan();
			view( $('#myTab li a.active').data('nilai') );
		});
		$('#akuntan').on('change', function() {
			view( $('#myTab li a.active').data('nilai') );
		});
		
		$('#tab-onproses').click(function() {
			view( $(this).data('nilai') );
		});
		$('#tab-belum').click(function() {
			view( $(this).data('nilai') );
		});
		$('#tab-selesai').click(function() {
			view( $(this).data('nilai') );
		});

		// Batal
		$('.showBatalProses').click(function() {
			var id		= $('.idProses').html();
			var status	= $('#myTab li a.active').data('nilai');
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/batal_'+status,
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

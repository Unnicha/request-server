<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>


	<!-- Judul Table-->
	<h2 align="center">Daftar Klien</h2>
	
	<div class="row float-left mt-1">
		<!-- Tombol Tambah Data -->
		<div class="col">
			<a href="<?= base_url(); ?>admin/klien/tambah" class="btn btn-success">
				<i class="bi-plus"></i>
				Tambah
			</a>
		</div>
	</div>
	
	<div class="mt-3 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm mt-3">
			<!-- Header Table-->
			<thead align="center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Klien</th>
					<th scope="col">Status</th>
					<th scope="col">Jenis Usaha</th>
					<th scope="col">Pimpinan</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<!-- Body Table-->
			<tbody align="center">
			</tbody>
		</table>
	</div>
</div>



<!-- Modal untuk Detail Profil -->
<div class="modal fade" id="detailProfil" tabindex="-1" aria-labelledby="detailProfilLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content profile-klien" id="showProfil">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>



<!-- Modal untuk Detail Akun -->
<div class="modal fade" id="detailAkun" tabindex="-1" aria-labelledby="detailAkunLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="showAkun">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() { 
		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function() { 
				$('#modalNotif').modal('hide'); 
			},2000);
		}
		
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
		})
		
		var table = $('#myTable').DataTable({
			'processing': true,
			'serverSide': true,
			'ordering'	: false,
			'lengthChange': false,
			//'pageLength': 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/klien/page',
				'type'	: 'post',
			},
		});

		// Profil
		$('#myTable tbody').on('click', 'a.btn-detail_profil', function() {
			var profil = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/klien/profil',
				data: 'action='+ profil,
				success: function(data) {
					$("#detailProfil").modal('show');
					$("#showProfil").html(data);
				}
			})
		});
	
		// Akun
		$('#myTable tbody').on('click', 'a.btn-detail_akun', function() {
			var akun = $(this).data('value');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/klien/akun',
				data: 'action='+ akun,
				success: function(data) {
					$("#detailAkun").modal('show');
					$("#showAkun").html(data);
				}
			})
		});
	})

</script>

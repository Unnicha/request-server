<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<!-- Judul Table-->
	<h2 align="center">Daftar Klien</h2>
	
	<div class="row float-left mt-1">
		<!-- Tombol Tambah Data -->
		<div class="col">
			<a href="<?= base_url(); ?>admin/master/klien/tambah" class="btn btn-success">
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
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content profile-klien" id="showProfil">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>

<!-- Detail Proses -->
<div class="modal fade modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" style="width:400px">
			<div class="modal-header pl-4">
				<h5 class="modal-title">Hapus Klien</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-3">
				<div class="row mb-4">
					<div class="col">
						<font size="4">
							Anda yakin ingin menghapus Klien <b class="namaKlien"></b> ?
						</font>
					</div>
				</div>
				<div class="idKlien" style="display:none"></div>
				<div class="row text-center">
					<div class="col">
						<a class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close">Batal</a>
						<a class="btn btn-danger fix-hapus">Hapus</a>
					</div>
				</div>
			</div>
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
		
		var table = $('#myTable').DataTable({
			'processing': true,
			'serverSide': true,
			'ordering'	: false,
			'lengthChange': false,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/master/klien/page',
				'type'	: 'post',
			},
		});
		
		// Profil
		$('#myTable tbody').on('click', 'a.btn-detail', function() {
			var profil = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/master/klien/profil',
				data: 'action='+ profil,
				success: function(data) {
					$("#detailProfil").modal('show');
					$("#showProfil").html(data);
				}
			})
		});
		
		//show tooltip
		$('#myTable').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})
		
		$('#myTable').on('click', '.btn-hapus', function() {
			$(".modalHapus").modal('show');
			$(".idKlien").html( $(this).data('id') );
			$(".namaKlien").html( $(this).data('nama') );
		})
		$('.fix-hapus').click(function() {
			var id = $('.idKlien').html();
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>admin/master/klien/hapus',
				data	: 'id=' +id,
				success	: function() {
					$('.modalHapus').modal('hide');
					window.location.assign("<?= base_url();?>admin/master/klien");
				}
			})
		})
	})
</script>

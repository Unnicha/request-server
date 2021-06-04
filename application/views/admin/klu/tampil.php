<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<!-- Judul Table-->
	<h2 align="center"><?=$judul?></h2>
	
	<div class="row mt-1 float-left">
		<!-- Tombol Tambah Data -->
		<div class="col">
			<a href="<?= base_url(); ?>admin/master/klu/tambah" class="btn btn-success">
				<i class="bi bi-plus"></i>
				Tambah 
			</a>
		</div>
	</div>
	
	<div class="mt-3 mb-4">
		<table id="myTable" class="table table-sm table-bordered table-striped table-responsive-sm my-3" width=100%>
			<!-- Header Table-->
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Kode KLU</th>
					<th scope="col">Bentuk Usaha</th>
					<th scope="col">Jenis Usaha</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<!-- Body Table-->
			<tbody class="isi text-center">
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() { 
		// pop up notif
		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
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
				'url'	: '<?=base_url()?>admin/master/klu/page',
				'type'	: 'post',
			},
		});
	})
</script>
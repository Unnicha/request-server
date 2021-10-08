<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
		<div class="col-auto">
			<a href="<?= base_url(); ?>admin/master/tugas/tambah" class="btn btn-primary">
				<i class="bi-plus-circle"></i>
				Tambah
			</a>
		</div>
	</div>
	
	<div class="card card-shadow">
		<div class="card-body p-0">
			<table id="myTable" width=100% class="table table-striped table-responsive-sm my-3">
				<thead class="text-center">
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Nama Tugas</th>
						<th scope="col">Jenis Data</th>
						<th scope="col">Accounting Service</th>
						<th scope="col">Review</th>
						<th scope="col">Semi Review</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				
				<tbody class="isi text-center">
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Hapus -->
<div class="modal fade modalConfirm" tabindex="-1" aria-labelledby="modalConfirmLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto showConfirm" style="width:400px">
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
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'pageLength'	: 8,
			'ajax'			: {
				'url'	: '<?=base_url()?>admin/master/tugas/page',
				'type'	: 'post',
			},
		})
		
		$('#myTable').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})
		
		$('#myTable').on('click', '.btn-hapus', function() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/master/tugas/hapus',
				data	: {
					'id'	: $(this).data('id'),
					'nama'	: $(this).data('nama'),
				},
				success	: function(data) {
					$(".modalConfirm").modal('show');
					$(".showConfirm").html(data);
				}
			})
		})
	})
</script>
<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif;
		if($this->session->flashdata('warning')) : ?>
		<div class="warning" data-val="yes"></div>
	<?php endif;
		if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-id="<?=$this->session->flashdata('pass')?>"></div>
	<?php endif ?>
	
	<div class="row mb-2">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
		<div class="col-auto">
			<a href="<?= base_url(); ?>admin/master/admin/tambah" class="btn btn-primary">
				<i class="bi-plus-circle"></i>
				Tambah
			</a> 
		</div>
	</div>
	
	<div class="card card-shadow">
		<div class="card-body p-0">
			<table id="myTable" width=100% class="table table-striped table-responsive-sm mt-3">
				<thead class="text-center">
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Nama Admin</th>
						<th scope="col">Username</th>
						<th scope="col">Email</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				
				<tbody class="text-center">
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade modalVerif" tabindex="-1" aria-labelledby="modalVerifLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto showVerif">
			<!-- Tampilkan Data -->
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
	$(document).ready(function () {
		//pop up message success
		if($('.notification').data('val') == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		//pop up message failed
		if($('.warning').data('val') == 'yes') {
			$('#modalWarning').modal('show');
			setTimeout(function(){ $('#modalWarning').modal('hide'); },2000);
		}
	
		//view table
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'pageLength'	: 8,
			'ajax'			: {
				'url'	: '<?=base_url()?>admin/master/admin/page',
				'type'	: 'post',
			},
		});
		
		//show tooltip
		$('#myTable').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})
		
		function verif(id) {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/master/admin/verif',
				data	: {
					'id'	: id,
				},
				success	: function(data) {
					$(".modalVerif").modal('show');
					$(".showVerif").html(data);
				}
			})
		}
		
		// Ubah Password
		$('#myTable tbody').on('click', 'a.btn-ubah', function() {
			verif( $(this).data('id') );
		});
		
		if($('.passVerif').data('val') == 'yes') {
			verif($('.passVerif').data('id'));
			$('.salah').html('Password salah!');
		}
		
		$('#myTable').on('click', '.btn-hapus', function() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/master/admin/hapus',
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
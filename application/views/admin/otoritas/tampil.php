<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?> 
	
	<?php if($this->session->flashdata('warning')) : ?>
		<div class="warning" data-val="yes"></div>
	<?php endif; ?> 

	<!-- Judul Table-->
	<h2 align="center"><?= $judul ?></h2>
	
	<div class="row float-left mt-1">
		<!-- Tombol Tambah Data -->
		<div class="col">
			<a href="<?= base_url(); ?>admin/master/otoritas/tambah" class="btn btn-success">
				<i class="bi-plus"></i>
				Tambah
			</a> 
		</div>
	</div>
	
	<div class="mt-3 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm mt-3">
			<!-- Header Table-->
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Admin</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<!-- Body Table-->
			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>


<!-- Detail Proses -->
<div class="modal fade modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" style="width:400px">
			<div class="modal-header pl-4">
				<h5 class="modal-title">Hapus Admin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-3">
				<div class="row mb-4">
					<div class="col">
						<font size="4">
							Anda yakin ingin menghapus Admin <b class="namaAdmin"></b> ?
						</font>
					</div>
				</div>
				<div class="idAdmin" style="display:none"></div>
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
		$(document).ready(function () {
			//pop up message success
			var notif = $('.notification').data('val');
			if(notif == 'yes') {
				$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
			}
			//pop up message failed
			var warning = $('.warning').data('val');
			if(warning == 'yes') {
				$('#modalWarning').modal('show');
				setTimeout(function(){ $('#modalWarning').modal('hide'); },2000);
			}

			//view table
			var table = $('#myTable').DataTable({
				'processing': true,
				'serverSide': true,
				'ordering'	: false,
				'lengthChange': false,
				'ajax'		: {
					'url'	: '<?=base_url()?>admin/master/otoritas/page',
					'type'	: 'post',
				},
			});

			//show tooltip
			$('#myTable').on('mouseover', '[data-toggle="tooltip"]', function() {
				$(this).tooltip();
			})
			
			$('#myTable').on('click', '.btn-hapus', function() {
				$(".modalHapus").modal('show');
				$(".idAdmin").html( $(this).data('id') );
				$(".namaAdmin").html( $(this).data('nama') );
			})
			$('.fix-hapus').click(function() {
				var id = $('.idAdmin').html();
				$.ajax({
					type	: 'post',
					url		: '<?= base_url(); ?>admin/master/otoritas/hapus',
					data	: 'id=' +id,
					success	: function() {
						$('.modalHapus').modal('hide');
						window.location.assign("<?= base_url();?>admin/master/otoritas");
					}
				})
			})
		})

</script>
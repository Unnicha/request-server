<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
		<div class="col-auto">
			<a href="<?= base_url(); ?>admin/master/akses/tambah" class="btn btn-primary">
				<i class="bi bi-plus-circle"></i>
				Tambah
			</a>
		</div>
	</div>
	
	<div class="card card-shadow">
		<div class="card-body p-0">
			<div class="row pt-1 my-2">
				<div class="col">
					<div class="form-inline">
						<div class="form-row mx-3">
							<label class="mr-2">Tahun</label>
							<select name='tahun' class="form-control" id="tahun">
								<?php
									$tahun = $_SESSION['tahun'] ? $_SESSION['tahun'] : date('Y');
									for($i=date('Y'); $i>=2010; $i--) :
										if ($i == $tahun) {
											$pilih="selected";
										} else {
											$pilih="";
										} ?>
								<option value="<?= $i ?>" <?= $pilih ?>> <?= $i ?> </option>
								<?php endfor ?>
							</select>
						</div>
					</div>
				</div>
				
				<!-- <div class="col-auto mx-3">
					<input type="text" class="form-control" name="akuntan" id="akuntan" placeholder="Cari Akuntan">
				</div> -->
			</div>
			
			<table id="myTable" width=100% class="table table-striped table-responsive-sm">
				<thead class="text-center">
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Nama Klien</th>
						<th scope="col">Mulai akses</th>
						<th scope="col">PJ Akuntansi</th>
						<th scope="col">PJ Perpajakan</th>
						<th scope="col">PJ Lainnya</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				
				<tbody align="center"></tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal untuk Detail -->
<div class="modal fade" id="detailAkses" tabindex="-1" aria-labelledby="detailAksesLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content" id="showAkses">
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
	$(document).ready(function() {
		if($('.notification').data('val') == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'pageLength'	: 8,
			'language'		: {
				emptyTable	: "Belum ada akses"
			},
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/master/akses/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
					},
			},
		});
		
		$('#tahun').change(function() {
			table.draw();
		})
		
		$('#myTable tbody').on('click', 'a.btn-detail', function() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/master/akses/detail',
				data	: 'action='+ $(this).data('nilai'),
				success	: function(data) {
					$("#detailAkses").modal('show');
					$("#showAkses").html(data);
				}
			})
		});
		
		$('#myTable').on('click', '.btn-hapus', function() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/master/akses/hapus',
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
<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="text-center"><?=$judul?></h2>
	
	<div class="row mb-2">
		<div class="col col-sm">
			<a href="<?= base_url(); ?>admin/master/akses/tambah" class="btn btn-success">
				<i class="bi bi-plus"></i>
				Tambah
			</a>
		</div>
		<div class="col col-sm">
			<div class="form-row form-inline float-right">
				<label class="col-form-label"><b>Tahun</b></label>
				<div class="col">
					<select name='tahun' class="form-control" id="tahun">
						<?php
							$tahun = $_SESSION['tahun'] ? $_SESSION['tahun'] : date('Y');
							for($i=$tahun; $i>=2010; $i--) :
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
	</div>
	
	<div class="mb-4">
		<table id="myTable" width=100% class="table table-akses table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Akuntan</th>
					<th scope="col">Mulai akses</th>
					<th scope="col">Klien</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			
			<tbody align="center"></tbody>
			
			<tfoot class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Akuntan</th>
					<th scope="col">Mulai akses</th>
					<th scope="col">Klien</th>
					<th scope="col">Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<!-- Modal untuk Detail -->
<div class="modal fade" id="detailAkses" tabindex="-1" aria-labelledby="detailAksesLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content profile-klien" id="showAkses">
			<!-- Tampilkan Data -->
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
		
		// Setup - add a text input to each footer cell
		$('#myTable tfoot th').each( function () {
			var title = $('#myTable thead th').eq( $(this).index() ).text();
			$(this).html( '<input type="text" placeholder="Cari '+title+'">' );
		});
	
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/master/akses/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
					},
			},
			/*'columnDefs'	: [
				{ 'targets': [0,1,2,4], 'searchable': false, }
			],*/
		});
		// Apply the filter
		table.columns().each( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change clear', function () {
				if ( that.search() !== this.value ) {
					that.search( this.value ).draw();
				}
			});
		});
		
		$('#bulan').change(function() {
			table.draw();
		})
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
	})
</script>
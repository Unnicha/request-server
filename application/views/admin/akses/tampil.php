<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	
	<!-- Judul Table-->
	<h2 class="text-center"><?=$judul?></h2>
	
	<div class="row">
		<!-- Tombol Tambah Akuntan -->
		<div class="col col-sm">
			<a href="<?= base_url(); ?>admin/master/akses/tambah" class="btn btn-success">
				<i class="bi bi-plus"></i>
				Tambah
			</a>
		</div>
		
		<!-- Ganti Tampilan -->
		<div class="col col-sm">
			<form action="" method="post">
				<div class="row form-inline form-group float-right mb-2">
						<!-- Ganti Tahun -->
						<select name='tahun' class="form-control" id="tahun">
							<?php 
								$tahun = date('Y');
								$sess_tahun = $this->session->userdata('tahun');
								for($i=$tahun; $i>=2010; $i--) :
									if ($i == $sess_tahun) 
										{ $pilih="selected"; } 
									else 
										{ $pilih=""; }
							?>
							<option value="<?= $i ?>" <?= $pilih ?>> <?= $i ?> </option>
							<?php endfor ?>
						</select>
				</div>
			</form>
		</div>
	</div>
	
	<div class="mb-4">
		<table id="myTable" width=100% class="table table-akses table-sm table-bordered table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Akuntan</th>
					<th scope="col">Mulai akses</th>
					<th scope="col">Klien</th>
					<th scope="col">Detail</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<tbody align="center">
			</tbody>
		</table>
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
			'searching'		: false,
			//'pageLength'	: 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/master/akses/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
					},
			},
			'columnDefs'	: [
				{
					'targets'	: 4,
					'visible'	: false,
				},
				{
					'targets'	: 3,
					'className'	: 'detail_klien',
				}
			]
		});
		
		//add row child
		function format ( d ) { // `d` is the original data object for the row
			var child = '<table class="table-bordered table-striped my-1" cellpadding="5" cellspacing="0" width=99%>';
			var n = d[4];
			for (var i = 0; i < n.length; i++) {
				var j = i+1;
				child += '<tr><td>Klien '+j+'</td><td>'+n[i]+'</td></tr>';
			}
			child += '</table>';
			return child;
		}
		//detail klien
		$('#myTable tbody').on('click', 'td.detail_klien', function () {
			var tr	= $(this).parents('tr');
			var row	= table.row( tr );
		
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row (the format() function would return the data to be shown)
				row.child( format(row.data()) ).show();
				tr.addClass('shown');
			}
		} );
		
		$('#bulan').change(function() {
			table.draw();
		})
		$('#tahun').change(function() {
			table.draw();
		})
	})
</script>
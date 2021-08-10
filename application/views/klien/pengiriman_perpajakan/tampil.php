<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="text-center"> <?= $judul; ?> </h2>
	
	<div class="row form-inline">
		<div class="col">
			<select name='bulan' class="form-control" id="bulan">
				<?php 
					$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
					foreach ($masa as $m) : 
						if ($m['id_bulan'] == $bulan) {
							$pilih = "selected";
						} else {
							$pilih = "";
						} ?>
				<option value="<?= $m['id_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
				<?php endforeach ?>
			</select>
			
			<select name='tahun' class="form-control" id="tahun">
				<?php 
					$tahun = ($this->session->userdata('tahun')) ? $this->session->userdata('tahun') : date('Y');
					for($i=$tahun; $i>=2016; $i--) :
						if ($i == $tahun) {
							$pilih = "selected";
						} else {
							$pilih = "";
						} ?>
				<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
				<?php endfor ?>
			</select>
		</div>
	</div>
	
	<div class="mt-2 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center ">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">ID Permintaan</th>
					<th scope="col">Permintaan</th>
					<th scope="col">Tanggal Permintaan</th>
					<th scope="col">Requestor</th>
					<th scope="col">Detail</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>

<!-- Modal untuk Detail Akun -->
<div class="modal fade" id="detailPermintaan" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content" id="showDetailPermintaan">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>


<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	function format ( rowData ) {
		var div = $('<div/>')
					.addClass( 'loading' )
					.text( 'Loading...' );
		
		$.ajax( {
			url		: '<?= base_url(); ?>klien/pengiriman_data_perpajakan/pageChild',
			data	: {
				id: rowData[1]
			},
			success	: function ( e ) {
				div
					.html( e )
					.removeClass( 'loading' );
			},
		} );
		return div;
	}
	
	$(document).ready(function() {
		if( $('.notification').data('val') == 'yes' ) {
			$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'language'		: {
				emptyTable	: "Belum ada pengiriman"
			},
			'ajax'			: {
				'url'	: '<?=base_url()?>klien/pengiriman_data_perpajakan/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val(); 
				},
			},
		});
		
		$('#bulan').change(function() {
			table.draw();
		})
		$('#tahun').change(function() {
			table.draw();
		})
		
		$('#myTable tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		});
		
		// Detail Permintaan
		$('#myTable tbody').on('click', 'a.btn-detail_pengiriman', function() {
			var tr	= $(this).closest('tr');
			var row	= table.row( tr );
			
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			} else {
				// Open this row
				row.child( format(row.data()) ).show();
				tr.addClass( 'shown' );
			}
		});
	});
</script>

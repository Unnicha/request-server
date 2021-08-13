<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	<?php if($this->session->flashdata('warning')) : ?>
		<div class="warning" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="row p-3">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<div class="card card-shadow mx-3">
		<div class="card-body">
			<form action="<?=base_url()?>akuntan/pengiriman_data_lainnya/export" method="post">
				<div class="row">
					<div class="col-sm px-0">
						<div class="row form-inline">
							<div class="col">
								<!-- Ganti Bulan -->
								<select name='bulan' class="form-control" id="bulan">
									<?php 
										$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
										foreach ($masa as $m) :
											$pilih = ($m['id_bulan'] == $bulan) ? "selected" : "";
										?>
									<option value="<?= $m['id_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
									<?php endforeach ?>
								</select>
								
								<!-- Ganti Tahun -->
								<select name='tahun' class="form-control" id="tahun">
									<?php 
										$tahun = $this->session->userdata('tahun') ? $this->session->userdata('tahun') : date('Y');
										for($i=date('Y'); $i>=2010; $i--) :
											$pilih = ($i == $tahun) ? "selected" : "";
										?>
									<option value="<?=$i?>" <?=$pilih?>> <?=$i?> </option>
									<?php endfor ?>
								</select>
								
								<!-- Ganti Klien -->
								<select name='klien' class="form-control" id="klien">
									<option value=""> Semua Klien </option>
								</select> 
							</div>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="btn-group float-right" role="group" aria-label="Export">
							<button type="submit" name="export" value="xls" class="btn btn-excel" data-toggle="tooltip" data-placement="bottom" title="Export Excel">
								<i class="bi bi-file-earmark-spreadsheet" style="font-size:20px"></i>
							</button>
							<button type="submit" name="export" value="pdf" class="btn btn-pdf" data-toggle="tooltip" data-placement="bottom" title="Export PDF">
								<i class="bi bi-file-earmark-pdf" style="font-size:20px"></i>
							</button>
						</div>
					</div>
				</div>
			</form>
			
			<div class="mt-2">
				<table id="myTable" width=100% class="table table-striped table-responsive-sm">
					<thead class="text-center">
						<tr>
							<th scope="col">No.</th>
							<th scope="col">Nama Klien</th>
							<th scope="col">ID Permintaan</th>
							<th scope="col">Permintaan</th>
							<th scope="col">Tanggal Permintaan</th>
							<th scope="col">Requestor</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
		
					<tbody class="text-center">
					</tbody>
				</table>
			</div>
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
			url		: '<?= base_url(); ?>akuntan/pengiriman_data_lainnya/pageChild',
			data	: {
				id: rowData[2]
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
		if($('.notification').data('val') == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		if($('.warning').data('val') == 'yes') {
			$('#modalWarning').modal('show');
			//setTimeout(function(){ $('#modalWarning').modal('hide'); },2000);
		}
		
		function klien() {
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/pengiriman_data_lainnya/klien',
				data: {
					'bulan':bulan,
					'tahun': tahun
				},
				success: function(data) {
					$("#klien").html(data);
				}
			})
		}
		klien();
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'language'		: {
				emptyTable	: "Belum ada pengiriman selesai"
			},
			//'pageLength': 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>akuntan/pengiriman_data_lainnya/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
			'columnDefs'	: [ 
				{
					className: "align-top",
					targets: "_all" },
				{
					'targets'	: 2,
					'visible'	: false,
				},
			],
		});
		
		$("#bulan").change(function() {
			klien();
			table.draw();
		});
		$("#tahun").change(function() {
			klien();
			table.draw();
		});
		$("#klien").change(function() {
			table.draw();
		});
		
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

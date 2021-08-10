<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="mb-3" align="center"><?= $judul ?></h2>
	
	<div class="row"> 
		<div class="col col-sm">
			<div class="row form-inline">
				<div class="col px-0">
					<!-- Ganti Bulan -->
					<select name='bulan' class="form-control" id="bulan">
						<?php 
							$bulan = $this->session->userdata('bulan') ? $this->session->userdata('bulan') : date('m');
							foreach ($masa as $m) :
								$pilih = ($m['id_bulan'] == $bulan) ? 'selected' : '';
							?>
						<option value="<?=$m['id_bulan']?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<!-- Ganti Tahun -->
					<select name='tahun' class="form-control" id="tahun">
						<?php 
							$tahun = $this->session->userdata('tahun') ? $this->session->userdata('tahun') : date('Y');
							for($i=date('Y'); $i>=2010; $i--) :
								$pilih = ($i == $sess_tahun) ? 'selected' : '';
							?>
						<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
						<?php endfor ?>
					</select>
					
					<!-- Ganti Klien -->
					<select name='klien' class="form-control" id="klien">
						<option value=""> Semua Klien </option>
							<?php 
							$sess_klien = $this->session->userdata('klien');
							foreach ($klien as $k) :
								$pilih = ($k['id_klien'] == $sess_klien) ? 'selected' : '';
							?>
						<option value="<?= $k['id_klien']; ?>" <?=$pilih?>> <?=$k['nama_klien']?> </option>
							<?php endforeach ?>
					</select>
				</div>
			</div>
		</div>
		
		<!-- Tombol Tambah Permintaan -->
		<div class="col col-sm-3">
			<a href="<?= base_url() ?>admin/permintaan/permintaan_data_akuntansi/tambah" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="bottom" title="Buat permintaan baru">
				<i class="bi-plus-circle"></i>
				Buat
			</a>
		</div>
	</div>
	
	<div class="mt-2 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
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

<div class="modal fade modalConfirm" tabindex="-1" aria-labelledby="modalConfirmLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" style="width:400px" id="showConfirm">
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
			url		: '<?= base_url(); ?>admin/permintaan/permintaan_data_akuntansi/pageChild',
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
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'language'		: {
				emptyTable	: "Belum ada permintaan"
			},
			//'pageLength': 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/permintaan/permintaan_data_akuntansi/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
			'columnDefs'	: [
				{
					'targets'	: 2,
					'visible'	: false,
				},
			],
		});
		
		// Selections
		$("#klien").change(function() { 
			table.draw();
		})
		$('#bulan').change(function() {
			table.draw();
		})
		$('#tahun').change(function() {
			table.draw();
		})
		
		// Toolips
		$('#myTable tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		});
		$('[data-toggle="tooltip"]').mouseover(function() {
			$(this).tooltip();
		});
		
		// Detail Permintaan
		$('#myTable tbody').on('click', 'a.btn-detail', function() {
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
		// Hapus
		$('#myTable tbody').on('click', 'a.btn-hapus', function() {
			var permintaan = $(this).data('nilai');
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/permintaan/permintaan_data_akuntansi/hapus',
				data	: 'permintaan='+ permintaan,
				success	: function(data) {
					$(".modalConfirm").modal('show');
					$("#showConfirm").html(data);
				}
			})
		});
	});
	
</script>
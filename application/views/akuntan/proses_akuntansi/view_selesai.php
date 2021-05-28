<div class="container-fluid p-0">
	
	<form action="<?=base_url()?>akuntan/proses_data_akuntansi/download" method="post" target="_blank">
		<div class="row mb-2">
			<div class="col form-inline">
				<select name="bulan" class="form-control mr-1" id="bulan_selesai">
					<?php 
						$bulan = date('m');
						$sess_bulan = $this->session->userdata('bulan');
						if($sess_bulan) {$bulan = $sess_bulan;}
	
						foreach ($masa as $m) : 
							if ($m['id_bulan'] == $bulan || $m['nama_bulan'] == $bulan) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
					?>
					<option value="<?= $m['nama_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
					<?php endforeach ?>
				</select>
				
				<select name="tahun" class="form-control mr-1" id="tahun_selesai">
					<?php 
						$tahun = date('Y');
						$sess_tahun = $this->session->userdata('tahun');
						for($i=$tahun; $i>=2010; $i--) :
							if ($i == $sess_tahun) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
					?>
					<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
					<?php endfor ?>
				</select>

				<select name="klien" class="form-control mr-1" id="klien_selesai">
					<option value="">--Tidak Ada Klien--</option>
				</select> 
			</div>

			<div class="col-2 pl-0">
				<div class="dropdown float-right">
					<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Export
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						<button type="submit" id="xls" name="xls" class="dropdown-item">Export Excel</button>
						<button type="submit" id="pdf" name="pdf" class="dropdown-item">Export PDF</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<div id="mb-4">
		<table id="myTable_selesai" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Klien</th>
					<th scope="col">Akuntan</th>
					<th scope="col">Tugas</th>
					<th scope="col">Durasi</th>
					<th scope="col">Standard</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>

<!-- Detail Proses -->
<div class="modal fade detailProses" tabindex="-1" aria-labelledby="detailProsesLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content profile-klien showProses">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		function gantiKlien() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>akuntan/proses_data_akuntansi/gantiKlien',
				data	: {
					bulan	: $('#bulan_selesai').val(), 
					tahun	: $('#tahun_selesai').val(), 
					},
				success	: function(data) {
					$("#klien_selesai").html(data);
				}
			})
		}
		var table = $('#myTable_selesai').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'pageLength': 8,
			'ajax'		: {
				'url'	: '<?=base_url()?>akuntan/proses_data_akuntansi/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien_selesai').val(); 
					e.bulan = $('#bulan_selesai').val(); 
					e.tahun = $('#tahun_selesai').val();
				},
			},
		});
		gantiKlien();
		table.draw();

		$("#bulan_selesai").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#tahun_selesai").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#klien_selesai").change(function() {
			table.draw();
		})

		$('#myTable_selesai tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})

		// Detail
		$('#myTable_selesai tbody').on('click', 'a.btn-detail', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/proses_data_akuntansi/detail',
				data: 'id='+ id,
				success: function(data) {
					$(".detailProses").modal('show');
					$(".showProses").html(data);
				}
			})
		});
	});
</script>

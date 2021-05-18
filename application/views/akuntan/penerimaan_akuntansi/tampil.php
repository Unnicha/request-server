<div class="container-fluid">

	<!-- Judul -->
	<h2 class="mb-3" align="center"> <?= $judul; ?> </h2>
	
			<div class="row form-inline">
				<div class="col">
					<!-- Ganti Bulan -->
					<select name='bulan' class="form-control" id="bulan">
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
						<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
						<?php endfor ?>
					</select>
					
					<!-- Ganti Klien -->
					<select name='klien' class="form-control" id="klien">
						<option value=""> Semua Klien </option>
							<?php 
							$sess_klien = $this->session->flashdata('klien');
							foreach ($klien as $k) :
								if ($k['id_klien'] == $sess_klien) 
									{ $pilih="selected"; } 
								else 
									{ $pilih=""; }
							?>
						<option value="<?= $k['id_klien']; ?>" <?= $pilih; ?>> 
							<?= $k['nama_klien'] ?> 
						</option>
							<?php endforeach ?>
					</select> 
				</div>
			</div>
	
	<div class="mt-2 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Klien</th>
					<th scope="col">Jenis Data</th>
					<th scope="col">Jenis Pengiriman</th>
					<th scope="col">Tanggal Pengiriman</th>
					<th scope="col">Detail</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>


<!-- Modal untuk Detail Pengiriman -->
<div class="modal fade" id="detailPengiriman" tabindex="-1" aria-labelledby="detailPengirimanLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" style="width:500px">
		<div class="modal-content" id="showDetailPengiriman">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>


<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'language'		: {
				emptyTable	: "Belum ada data diterima"
			},
			//'pageLength': 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/penerimaan_data_akuntansi/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
		});
		
		function klien() {
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/penerimaan_data_akuntansi/klien',
				data: {'bulan':bulan, 'tahun': tahun},
				success: function(data) {
					$("#klien").html(data);
				}
			})
		}
		klien();
		
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
			var pengiriman = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/penerimaan_data_akuntansi/detail',
				data: 'action='+ pengiriman,
				success: function(data) {
					$("#detailPengiriman").modal('show');
					$("#showDetailPengiriman").html(data);
				}
			})
		});
	});
</script>
<!--
-->

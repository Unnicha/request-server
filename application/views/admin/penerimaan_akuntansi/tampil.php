<div class="container-fluid"> 

	<!-- Judul Table-->
	<h2 class="mb-3" align="center"> <?= $judul; ?> </h2>
	 
	<!-- Form Ganti Tampilan -->
	<form action="<?=base_url()?>admin/penerimaan/penerimaan_data_akuntansi/cetak" method="post" target="_blank">
		<div class="row form-inline">
			<div class="col-12 col-sm">
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
						$sess_klien = $this->session->userdata('klien');
						foreach ($klien as $k) :
							if ($k['id_klien'] == $sess_klien) 
								{ $pilih="selected"; } 
							else 
								{ $pilih=""; }
						?>
					<option value="<?= $k['id_klien']; ?>" <?= $pilih; ?>><?= $k['nama_klien'] ?></option>
						<?php endforeach ?>
				</select> 
			</div>
				
			<div class="col-12 col-sm-4 col-lg-3">
				<div class="row float-sm-right">
					<button type="submit" name="xls" class="btn btn-success mr-1">
						<i class="bi bi-download"></i>
						Excel
					</button>
					<button type="submit" name="pdf" class="btn btn-danger">
						<i class="bi bi-download"></i>
						PDF
					</button>
				</div>
			</div>
		</div>
	</form>
	
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
	<div class="modal-dialog modal-dialog-scrollable modal-lg" style="width:600px">
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
				'url'	: '<?=base_url()?>admin/penerimaan/penerimaan_data_akuntansi/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
		});
		
		$("#klien").change(function() { 
			table.draw();
		})
		$('#bulan').change(function() {
			table.draw();
		})
		$('#tahun').change(function() {
			table.draw();
		})

		// Detail Pengiriman
		$('#myTable tbody').on('click', 'a.btn-detail_pengiriman', function() {
			var pengiriman = $(this).data('nilai');
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/penerimaan/penerimaan_data_akuntansi/detail',
				data	: 'action='+ pengiriman,
				success	: function(data) {
					$("#detailPengiriman").modal('show');
					$("#showDetailPengiriman").html(data);
				},
			})
		})
		$('#myTable tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})
	});

</script>
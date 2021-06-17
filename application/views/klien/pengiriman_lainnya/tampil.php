<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<!-- Judul -->
	<h2 class="text-center"> <?= $judul; ?> </h2>

	<div class="row form-inline"> 
		<div class="col">
			<!-- Ganti Bulan -->
			<select name='bulan' class="form-control" id="bulan">
				<?php 
					$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
					foreach ($masa as $m) : 
						if ($m['id_bulan'] == $bulan) 
							{ $pilih="selected"; } 
						else 
							{ $pilih=""; }
							?>
				<option value="<?= $m['id_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
				<?php endforeach ?>
			</select>
			
			<!-- Ganti Tahun -->
			<select name='tahun' class="form-control" id="tahun">
				<?php 
					$tahun = date('Y');
					$sess_tahun = $this->session->userdata('tahun');
					for($i=$tahun; $i>=2016; $i--) :
						if ($i == $sess_tahun) 
						{ $pilih="selected"; } 
						else 
						{ $pilih=""; }
				?>
				<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
				<?php endfor ?>
			</select>
		</div>
	</div>
	
	<div class="mt-2 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Permintaan</th>
					<th scope="col">Pengiriman</th>
					<th scope="col">Tanggal Pengiriman</th>
					<th scope="col">Status</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>


<!-- Modal untuk Detail Pengiriman -->
<div class="modal fade" id="detailPengiriman" tabindex="-1" aria-labelledby="detailPengirimanLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content" id="showDetailPengiriman">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>


<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		// Pop-up message success
		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		// Menampilkan data dengan DataTable
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'language'		: {
				emptyTable	: "Belum ada data terkirim"
			},
			//'pageLength': 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>klien/pengiriman_data_lainnya/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
			'columnDefs'	: [ 
				{ className: "align-top", targets: "_all" },
			],
		});

		// Fungsi untuk ganti tampilan
		$("#bulan").change(function() { 
			table.draw();
		});
		$("#tahun").change(function() { 
			table.draw();
		});
		
		// Mengaktifkan tooltip
		$('#myTable tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		});
		
		// Detail Pengiriman
		$('#myTable tbody').on('click', 'a.btn-detail_pengiriman', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>klien/pengiriman_data_lainnya/detail',
				//data	: 'action ='+ id,
				data	: {action : id},
				success	: function(data) {
					$("#detailPengiriman").modal('show');
					$("#showDetailPengiriman").html(data);
				}
			})
		});
	});
</script>
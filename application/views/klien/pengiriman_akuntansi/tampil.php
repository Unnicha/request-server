<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif ?>
	
	<div class="row mb-2">
		<div class="col">
			<h3> <?= $judul ?> </h3>
		</div>
	</div>
	
	<div class="card card-shadow">
		<div class="card-header">
			<div class="row form-inline">
				<div class="col">
					<select name='bulan' class="form-control" id="bulan">
						<?php 
							$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
							foreach ($masa as $m) :
								$pilih = ($m['id_bulan'] == $bulan) ? "selected" : "";
						?>
						<option value="<?= $m['id_bulan'] ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<select name='tahun' class="form-control" id="tahun">
						<?php 
							$tahun = ($this->session->userdata('tahun')) ? $this->session->userdata('tahun') : date('Y');
							for($i=$tahun; $i>=2016; $i--) :
								$pilih = ($i == $tahun) ? "selected" : "";
						?>
						<option value="<?= $i ?>" <?= $pilih ?>> <?= $i ?> </option>
						<?php endfor ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="card-body p-0">
			<table id="myTable" class="table table-striped table-responsive-sm" width=100% style="margin-top:0!important">
				<thead class="text-center ">
					<tr>
						<th scope="col">No.</th>
						<th scope="col">ID</th>
						<th scope="col">Permintaan</th>
						<th scope="col">Tanggal Permintaan</th>
						<th scope="col">Jumlah Data</th>
						<th scope="col">Requestor</th>
						<th scope="col">Status</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
	
				<tbody class="text-center">
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Detail -->
<div class="modal fade modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content showDetail">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
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
			'pageLength': 9,
			'ajax'			: {
				'url'	: '<?=base_url()?>klien/pengiriman_data_akuntansi/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val(); 
				},
			},
			'columnDefs'	: [
				{
					'targets'	: 1,
					'visible'	: false,
				},
			],
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
		$('#myTable tbody').on('click', 'a.btn-detail', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>klien/pengiriman_data_akuntansi/detail',
				data	: 'id='+ id,
				success	: function(data) {
					$(".modalDetail").modal('show');
					$(".showDetail").html(data);
				}
			})
		});
	});
</script>

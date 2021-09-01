<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<div class="card card-round">
		<div class="card-body p-0">
			<form action="<?=base_url()?>admin/pengiriman/pengiriman_data_perpajakan/cetak" method="post" target="_blank">
				<div class="row form-inline px-4 pt-3">
					<div class="col-sm">
						<!-- Ganti Bulan -->
						<select name='bulan' class="form-control" id="bulan">
							<?php
								$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
								foreach ($masa as $m) :
									$pilih = ($m['id_bulan'] == $bulan) ? 'selected' : '';
								?>
							<option value="<?= $m['id_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
							<?php endforeach ?>
						</select>
						
						<!-- Ganti Tahun -->
						<select name='tahun' class="form-control" id="tahun">
							<?php 
								$tahun = ($this->session->userdata('tahun')) ? $this->session->userdata('tahun') : date('Y');
								for($i=$tahun; $i>=2010; $i--) :
									$pilih = ($i == $sess_tahun) ? 'selected' : '';
								?>
							<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
							<?php endfor ?>
						</select>
		
						<!-- Ganti Klien -->
						<select name='klien' class="form-control" id="klien">
							<option value="">Semua Klien</option>
								<?php 
								$sess_klien = $this->session->userdata('klien');
								foreach ($klien as $k) :
									$pilih = ($k['id_klien'] == $sess_klien) ? 'selected' : '';
								?>
							<option value="<?=$k['id_klien']?>" <?=$pilih?>> <?=$k['nama_klien']?> </option>
								<?php endforeach ?>
						</select> 
					</div>
						
					<div class="col-auto">
						<div class="row float-right">
							<div class="col">
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

<!-- Detail Proses -->
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
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/pengiriman/pengiriman_data_perpajakan/page',
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
		
		// Detail Pengiriman
		$('#myTable tbody').on('click', 'a.btn-detail', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/pengiriman/pengiriman_data_perpajakan/detail',
				data	: 'id='+ id,
				success	: function(data) {
					$(".modalDetail").modal('show');
					$(".showDetail").html(data);
				}
			})
		});
	});
</script>
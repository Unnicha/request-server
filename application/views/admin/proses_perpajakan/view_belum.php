<div class="container-fluid p-0">
		<div class="row mb-2">
			<div class="col form-inline">
				<select name="akuntan" class="form-control mr-1" id="akuntan_belum">
					<option value="">--Semua Akuntan--</option>
					<?php foreach ($akuntan as $ak) : ?>
					<option value="<?= $ak['id_user']; ?>"> <?= $ak['nama'] ?> </option>
					<?php endforeach ?>
				</select>
				
				<select name="bulan" class="form-control mr-1" id="bulan_belum">
					<?php
						$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
						foreach ($masa as $m) : 
							if ($m['id_bulan'] == $bulan) {
								$pilih="selected";
							} else {
								$pilih="";
							} ?>
					<option value="<?= $m['id_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
					<?php endforeach ?>
				</select>
				
				<select name="tahun" class="form-control mr-1" id="tahun_belum">
					<?php 
						$tahun = ($this->session->userdata('tahun')) ? $this->session->userdata('tahun') : date('Y');
						for($i=$tahun; $i>=2010; $i--) :
							if ($i == $tahun) {
								$pilih="selected";
							} else {
								$pilih="";
							} ?>
					<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
					<?php endfor ?>
				</select>
				
				<select name="klien" class="form-control mr-1" id="klien_belum">
					<option value="">--Tidak Ada Klien--</option>
				</select> 
			</div>
		</div>
	
	<div id="mb-4">
		<table id="myTable_belum" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Klien</th>
					<th scope="col">Jenis Data</th>
					<th scope="col">Tugas</th>
					<th scope="col">Permintaan</th>
					<th scope="col">Pengiriman</th>
					<th scope="col">Lama Pengerjaan</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		function gantiKlien() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/gantiKlien',
				data	: {
					'akuntan'	: $('#akuntan_belum').val(), 
					'bulan'		: $('#bulan_belum').val(), 
					'tahun'		: $('#tahun_belum').val(), 
					},
				success: function(data) {
					$("#klien_belum").html(data);
				}
			})
		}
		gantiKlien();
		
		var table = $('#myTable_belum').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'pageLength'	: 8,
			'language'		: {
				emptyTable	: "Belum ada proses"
			},
			'ajax'			: {
				'url'	: '<?=base_url()?>admin/proses/proses_data_perpajakan/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien_belum').val(); 
					e.bulan = $('#bulan_belum').val(); 
					e.tahun = $('#tahun_belum').val();
				},
			},
		});

		$("#akuntan_belum").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#bulan_belum").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#tahun_belum").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#klien_belum").change(function() {
			table.draw();
		})
		
		$('#myTable_belum tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})
	});
</script>

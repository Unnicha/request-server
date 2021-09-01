<div class="container-fluid p-0">
		<div class="row mb-2">
			<div class="col form-inline">
				<select name="akuntan" class="form-control mr-1" id="akuntan_belum">
					<option value="">--Semua Akuntan--</option>
					<?php 
						$id_ak = ($_SESSION['akuntan']) ? $_SESSION['akuntan'] : '';
						foreach ($akuntan as $ak) :
							$pilih = ($ak['id_user'] == $id_ak) ? "selected" : "";
						?>
					<option value="<?= $ak['id_user']?>" <?=$pilih?>> <?= $ak['nama'] ?> </option>
					<?php endforeach ?>
				</select>
				
				<select name="bulan" class="form-control mr-1" id="bulan_belum">
					<?php
						$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
						foreach ($masa as $m) :
							$pilih = ($m['id_bulan'] == $bulan) ? "selected" : "";
						?>
					<option value="<?= $m['id_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
					<?php endforeach ?>
				</select>
				
				<select name="tahun" class="form-control mr-1" id="tahun_belum">
					<?php 
						$tahun = ($this->session->userdata('tahun')) ? $this->session->userdata('tahun') : date('Y');
						for($i=date('Y'); $i>=2010; $i--) :
							$pilih = ($i == $tahun) ? "selected" : "";
						?>
					<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
					<?php endfor ?>
				</select>
				
				<select name="klien" class="form-control mr-1" id="klien_belum">
					<option value="">--Tidak Ada Klien--</option>
				</select> 
			</div>
		</div>
	
	<div id="mb-4">
		<table id="myTable_belum" width=100% class="table table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Klien</th>
					<th scope="col">Data</th>
					<th scope="col">Tugas</th>
					<th scope="col">Estimasi</th>
					<th scope="col">Action</th>
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
				url		: '<?= base_url(); ?>admin/proses/proses_data_lainnya/gantiKlien',
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
				'url'	: '<?=base_url()?>admin/proses/proses_data_lainnya/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.akuntan	= $('#akuntan_belum').val(); 
					e.klien		= $('#klien_belum').val(); 
					e.bulan		= $('#bulan_belum').val(); 
					e.tahun		= $('#tahun_belum').val();
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
		
		// Detail
		$('#myTable_belum tbody').on('click', 'a.btn-detail', function() {
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses/proses_data_lainnya/detail',
				data: {
					'id_data'	: $(this).data('id'),
					'id_proses'	: $(this).data('proses'),
				},
				success: function(data) {
					$(".detailProses").modal('show');
					$(".showProses").html(data);
				}
			})
		});
	});
</script>

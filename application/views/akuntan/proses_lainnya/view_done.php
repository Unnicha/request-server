<div class="container-fluid p-0">
	<div class="row mb-2">
		<div class="col form-inline">
			<select name="bulan" class="form-control mr-1" id="bulan_selesai">
				<?php 
					$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
					foreach ($masa as $m) :
						$pilih = ($m['id_bulan'] == $bulan) ? "selected" : "";
					?>
				<option value="<?= $m['id_bulan'] ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
				<?php endforeach ?>
			</select>
			
			<select name="tahun" class="form-control mr-1" id="tahun_selesai">
				<?php 
					$tahun = ($this->session->userdata('tahun')) ? $this->session->userdata('tahun') : date('Y');
					for($i=$tahun; $i>=2010; $i--) :
						$pilih = ($i == $tahun) ? "selected" : "";
					?>
				<option value="<?= $i ?>" <?= $pilih ?>> <?= $i ?> </option>
				<?php endfor ?>
			</select>
			
			<select name="klien" class="form-control mr-1" id="klien_selesai">
				<option value="">--Tidak Ada Klien--</option>
			</select>
			
			<a href="javascript:window.location.reload()" class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="bottom" title="Refresh">
				<i class="bi bi-arrow-counterclockwise"></i>
			</a>
		</div>
	</div>
	
	<div id="mb-4">
		<table id="myTable_selesai" width=100% class="table table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Klien</th>
					<th scope="col">Tugas</th>
					<th scope="col">Akuntan</th>
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

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		function gantiKlien() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>akuntan/proses_data_lainnya/gantiKlien',
				data	: {
					bulan	: $('#bulan_selesai').val(), 
					tahun	: $('#tahun_selesai').val(), 
					},
				success	: function(data) {
					$("#klien_selesai").html(data);
				}
			})
		}
		gantiKlien();
		var table = $('#myTable_selesai').DataTable({
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
				'url'	: '<?=base_url()?>akuntan/proses_data_lainnya/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien_selesai').val(); 
					e.bulan = $('#bulan_selesai').val(); 
					e.tahun = $('#tahun_selesai').val();
				},
			},
		});
		
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

		$('.container-fluid').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})

		// Detail
		$('#myTable_selesai tbody').on('click', 'a.btn-detail', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/proses_data_lainnya/detail',
				data: 'id='+ id,
				success: function(data) {
					$(".detailProses").modal('show');
					$(".showProses").html(data);
				}
			})
		});
	});
</script>

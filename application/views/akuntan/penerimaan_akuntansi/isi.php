<!-- Mulai Table-->
<table class="table table-sm table-bordered table-striped" id="tabelData">
		
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Nama Klien</th>
				<th scope="col">Jenis Data</th>
				<th scope="col">Jenis Pengiriman</th>
				<th scope="col">Format Data</th>
				<th scope="col">Tanggal Pengiriman</th>
				<th scope="col">Detail</th>
			</tr>
		</thead>

		<!-- Body Table-->
		<tbody class="text-center">
			<?php 
				$no=0;
				foreach($pengiriman as $a) : 
			?>
			<tr>
				<td><?= ++$no ?>.</td>
				<td><?= $a['nama_klien'] ?></td>
				<td><?= $a['jenis_data'] ?></td>
					<?php
						if($a['pembetulan'] == 0) :
					?>
					<td>Pertama</td>
					<?php else : ?>
					<td>Pembetulan <?= $a['pembetulan']; ?></td>
					<?php endif; ?>
				<td><?= $a['format_data'] ?></td>
				<td><?= $a['tanggal_pengiriman'] ?></td>
				<td>
					<a href="#" class="btn btn-detail_pengiriman btn-sm btn-info" data-nilai="<?= $a['id_pengiriman'] ?>">
						<i class="bi-search"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
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



<script>
		// Detail Pengiriman
		$('.btn-detail_pengiriman').on('click', function() {
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
</script>


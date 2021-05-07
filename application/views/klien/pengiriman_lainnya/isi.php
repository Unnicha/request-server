<!-- Mulai Table-->
<table class="table table-sm table-bordered" id="tabelData">
		
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Jenis Data</th>
				<th scope="col">Pembetulan</th>
				<th scope="col">Format Data</th>
				<th scope="col">Tanggal</th>
				<th scope="col">Action</th>
			</tr>
		</thead>

		<!-- Body Table-->
		<tbody class="text-center">
			<?php 
				$no = 0;
				foreach($pengiriman as $a) : 
			?>
			<tr>
				<td ><?= ++$no ?>.</td>
				<td><?= $a['jenis_data']; ?></td>
					<?php if($a['pembetulan'] == 0) : ?>
				<td>Utama</td>
					<?php else : ?>
				<td>Pembetulan <?= $a['pembetulan']; ?></td>
					<?php endif; ?>
				<td><?= $a['format_data'] ?></td>
				<td><?= $a['tanggal_pengiriman'] ?></td>
				<td>
					<a href="#" class="btn btn-sm btn-info btn-detail_pengiriman" data-nilai="<?= $a['id_pengiriman'] ?>" data-toggle="tooltip" data-placement="bottom" title="Detail Pengiriman">
						<i class="bi bi-info-circle"></i>
					</a>
					<a href="<?= base_url(); ?>klien/pengiriman_data_perpajakan/pembetulan/<?=$a['id_permintaan']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Kirim Pembetulan">
						<i class="bi bi-pencil-square"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>


<!-- Modal untuk Detail Pengiriman -->
<div class="modal fade" id="detailPengiriman" tabindex="-1" aria-labelledby="detailPengirimanLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" style="width:600px">
		<div class="modal-content" id="showDetailPengiriman">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>



<!-- Load Jquery & Datatable JS -->
<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

		// Detail Pengiriman
		$('.btn-detail_pengiriman').on('click', function() {
			var pengiriman = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>klien/pengiriman_data_perpajakan/detail',
				data: 'action='+ pengiriman,
				success: function(data) {
					$("#detailPengiriman").modal('show');
					$("#showDetailPengiriman").html(data);
				}
			})
		});
</script>


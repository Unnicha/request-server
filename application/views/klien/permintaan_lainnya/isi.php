<!-- Mulai Table-->
<table class="table table-sm table-bordered">
		
		<!-- Header Table-->
		<thead class="text-center ">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Data yang Diminta</th>
				<th scope="col">Masa</th>
				<th scope="col">Tahun</th>
				<th scope="col">Format</th>
				<th scope="col">Tanggal Permintaan</th>
				<th scope="col">Action</th>
			</tr>
		</thead>

		<!-- Body Table-->
		<tbody class="text-center">
			<?php 
				$no=0;
				foreach($permintaan as $a) : 
			?>
			<tr>
				<td><?= ++$no ?>.</td>
				<td><?= $a['jenis_data'] ?></td>
				<td><?= $a['masa'] ?></td>
				<td><?= $a['tahun'] ?></td>
				<td><?= $a['format_data'] ?></td>
				<td><?= $a['tanggal_permintaan'] ?></td>
				<td>
					<a class="btn-detail btn btn-sm btn-info" data-nilai="<?= $a['id_permintaan']; ?>" data-toggle="tooltip" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle"></i>
					</a>
					<a class="btn btn-sm btn-success" href="<?= base_url(); ?>klien/permintaan_data_lainnya/kirim/<?= $a['id_permintaan']; ?>" data-toggle="tooltip" data-placement="bottom" title="Kirim Data">
						<i class="bi bi-file-earmark-arrow-up"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>



<!-- Modal untuk Detail Akun -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="showPermintaan">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>



<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
	
	$('.btn-detail').on('click', function() {
		var id_permintaan = $(this).data('nilai');
		$.ajax({
			type: 'POST',
			url: '<?= base_url(); ?>klien/permintaan_data_lainnya/detail',
			data: 'id_permintaan='+ id_permintaan,
			success: function(data) {
				$("#modalDetail").modal('show');
				$("#showPermintaan").html(data);
			}
		})
	});
</script>
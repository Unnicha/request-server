<!-- Mulai Table-->
<table class="table table-sm table-bordered table-striped table-responsive-sm" id="tabelData">
		
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Nama Klien</th>
				<th scope="col">Jenis Data</th>
				<th scope="col">Format</th>
				<th scope="col">Tanggal Permintaan</th>
				<th scope="col">Status</th>
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
				<td><?= $a['nama_klien'] ?></td>
				<td><?= $a['jenis_data'] ?></td>
				<td><?= $a['format_data'] ?></td>
				<td><?= $a['tanggal_permintaan'] ?></td>
				<td>
					<?php 
						$status = 0;
						foreach($pengiriman as $b) :
							if($b['id_permintaan'] == $a['id_permintaan']) {
								$status = 1;
							}
						endforeach;

						if($status == 0) {
					?>
					<i class="bi bi-hourglass-split icon-status" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Belum Diterima"></i>
					<?php } else { ?>
					<i class="bi bi-check-circle-fill icon-status" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Sudah Diterima"></i>
				</td>
					<?php } ?>
				<td>
					<a class="btn btn-sm btn-primary btn-detail_permintaan" data-nilai="<?= $a['id_permintaan'] ?>" data-toggle="tooltip" data-placement="bottom" title="Detail">
						<i class="bi bi-info-circle"></i>
					</a>

					<a href="<?= base_url(); ?>admin/permintaan_data_lainnya/hapus/<?= $a['id_permintaan']; ?>" class="btn btn-sm btn-danger " onclick="return confirm('Yakin ingin menghapus permintaan <?= $a['jenis_data'].' untuk '.$a['nama_klien'] ?>?');" data-toggle="tooltip" data-placement="bottom" title="Hapus">
						<i class="bi bi-trash"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>



<!-- Modal untuk Detail Permintaan -->
<div class="modal fade" id="detailPermintaan" tabindex="-1" aria-labelledby="detailPermintaanLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" style="width:500px">
		<div class="modal-content" id="showDetailPermintaan">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>



<script>
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
		})
	
		// Detail Permintaan
		$('.btn-detail_permintaan').on('click', function() {
			var permintaan = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/permintaan_data_lainnya/detail',
				data: 'permintaan='+ permintaan,
				success: function(data) {
					$("#detailPermintaan").modal('show');
					$("#showDetailPermintaan").html(data);
				}
			})
		});
</script>


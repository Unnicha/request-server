<!-- Mulai Table-->
<table class="table table-sm table-striped table-bordered table-responsive-sm mb-3" id="tabelData">
		
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Nama Klien</th>
				<th scope="col">Tugas</th>
				<th scope="col">Jenis Data</th>
				<th scope="col">Revisi</th>
				<th scope="col">Format Data</th>
				<th scope="col">Lama Pengerjaan</th>
				<th scope="col">Action</th>
			</tr>
		</thead>

		<!-- Body Table-->
		<tbody class="text-center">
			<?php 
				$no=0;
				foreach($pengiriman as $a) : 
					$hari	= floor($a['lama_pengerjaan'] / 8);
					$jam	= $a['lama_pengerjaan'] % 8;
					$standar= $hari.' hari '.$jam.' jam';
			?>
			<tr>
				<td><?= ++$no ?>.</td>
				<td><?= $a['nama_klien'] ?></td>
				<td><?= $a['nama_tugas'] ?></td>
				<td><?= $a['jenis_data'] ?></td>
				<td><?= $a['pembetulan'] ?></td>
				<td><?= $a['format_data'] ?></td>
				<td><?= $standar ?></td>
				<td>
					<a href="<?= base_url(); ?>akuntan/proses_data_lainnya/mulai/<?=$a['id_pengiriman']?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Mulai Proses">
						<i class="bi bi-journal-plus"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>



<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
</script>


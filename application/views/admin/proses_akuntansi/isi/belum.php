	<!-- Mulai Table-->
	<table class="table table-sm table-bordered table-striped table-responsive-sm mb-1" id="tabelData">
		
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
			</tr>
		</thead>

		<!-- Body Table-->
		<tbody class="text-center">
			<?php 
				$no=0;
				foreach($proses as $a) : 
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
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
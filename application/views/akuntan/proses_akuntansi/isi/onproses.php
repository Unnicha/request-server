	<!-- Mulai Table-->
	<table class="table table-sm table-striped table-bordered table-responsive-sm mb-3" id="isiProses">
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Klien</th>
				<th scope="col">Akuntan</th>
				<th scope="col">Tugas</th>
				<th scope="col">Revisi</th>
				<th scope="col">Mulai</th>
				<th scope="col">Durasi</th>
				<th scope="col">Standard</th>
				<th scope="col">Selesai</th>
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
				<td><?= $a['nama'] ?></td>
				<td><?= $a['nama_tugas'] ?></td>
				<td><?= $a['pembetulan'] ?></td>
				<td><?= $a['tanggal_mulai'] ?> <?= $a['jam_mulai'] ?></td>
				<td></td>
				<td><?= $standar ?></td>
				<td>
					<a class="btn btn-sm btn-warning" href="<?= base_url(); ?>akuntan/proses_data_akuntansi/selesai/<?=$a['id_proses']?>" data-toggle="tooltip" data-placement="bottom" title="Selesaikan Proses">
						<i class="bi bi-journal-check"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>



<script>
	$(document).ready(function() {
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});
		
		function durasi(mulai) {
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>akuntan/proses_data_akuntansi/hitung_durasi',
				data: {mulai:mulai},
				async: false,
				dataType: 'html',
				success: function(resp) {
					myVar = resp;
				},
				error: function() {
					return "ini eror";
				}
			});
			return myVar;
		}
		
		function autoload() {
			var table = document.getElementById("isiProses");
			for(var i=1; i<table.rows.length; i++) {
				var mulai = table.rows[i].cells[5].innerHTML;
				table.rows[i].cells[6].innerHTML = durasi(mulai);
			}
		}
		autoload();
	})
</script>


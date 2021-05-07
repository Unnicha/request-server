	<!-- Mulai Table-->
	<table class="table table-sm table-bordered table-striped table-responsive-sm mb-1" id="isiProses">
		
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Nama Akuntan</th>
				<th scope="col">Nama Klien</th>
				<th scope="col">Tugas</th>
				<th scope="col">Revisi</th>
				<th scope="col">Tanggal Mulai</th>
				<th scope="col">Durasi</th>
				<th scope="col">Standard</th>
			</tr>
		</thead>

		<!-- Body Table-->
		<tbody class="text-center" id="isiTable">
			<?php 
				$no=0;
				foreach($proses as $a) : 
					$hari	= floor($a['lama_pengerjaan'] / 8);
					$jam	= $a['lama_pengerjaan'] % 8;
					$standar= $hari.' hari '.$jam.' jam';
			?>
			<tr>
				<td><?= ++$no ?>.</td>
				<td><?= $a['nama'] ?></td>
				<td><?= $a['nama_klien'] ?></td>
				<td><?= $a['nama_tugas'] ?></td>
				<td><?= $a['pembetulan'] ?></td>
				<td class="tanggal"><?= $a['tanggal_mulai'] ?> <?= $a['jam_mulai'] ?></td>
				<td class="durasi"></td>
				<td><?= $standar ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	


<script>
	$(document).ready(function() {
		function durasi(mulai) {
			var hasil = "kosong";
			var hitung = $.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/proses_data_lainnya/hitung_durasi',
				data: { mulai:mulai,},
				async: false,
				dataType: 'html',
			});
			hitung.done(function(resp) {
				hasil = resp;
			})
			return hasil;
		}
		
		function reload() {
			var table = document.getElementById("isiProses");
			for(var i=1; i<table.rows.length; i++) {
				var mulai = table.rows[i].cells[5].innerHTML;
				table.rows[i].cells[6].innerHTML = durasi(mulai);
			}
		}

		function now() {
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>admin/proses_data_lainnya/nowDate',
				success: function(e) {
					$("#nowDate").html(e);
				}
			})
		}

		reload();
		//now();
		//var auto_refresh = setInterval(function() {reload()}, 10000);
		//var auto_refresh = setInterval(function() {now()}, 10000);
	})
</script>


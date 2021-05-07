<!-- Mulai Table-->
<table class="table table-sm table-striped table-bordered table-responsive-sm mb-3" id="isiSelesai">
		
		<!-- Header Table-->
		<thead class="text-center">
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Klien</th>
				<th scope="col">Akuntan</th>
				<th scope="col">Tugas</th>
				<th scope="col">Rev</th>
				<th scope="col">Mulai</th>
				<th scope="col">Selesai</th>
				<th scope="col">Durasi</th>
				<th scope="col">Standard</th>
				<!--
				<th scope="col">Action</th>
				-->
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
				<td><?= $a['tanggal_selesai'] ?> <?= $a['jam_selesai'] ?></td>
				<td></td>
				<td><?= $standar ?></td>
				<!--
				<td>
					<a class="btn btn-sm btn-info" href="<?=base_url()?>akuntan/proses_data_lainnya/selesai/<?=$a['id_proses']?>">
						<i class="bi bi-pencil-square"></i>
					</a>
				</td>
				-->
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
</div>


<!-- Modal untuk Detail Pengiriman -->
<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" style="width:600px">
		<div class="modal-content" id="showDetail">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>



<!-- Load Jquery & Datatable JS -->
<script>
	$(document).ready(function() {
		function durasi(mulai, selesai) {
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>akuntan/proses_data_lainnya/hitung_durasi',
				data: { mulai:mulai, selesai:selesai},
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
			var table = document.getElementById("isiSelesai");
			for(var i=1; i<table.rows.length; i++) {
				var mulai = table.rows[i].cells[5].innerHTML;
				var selesai = table.rows[i].cells[6].innerHTML;
				table.rows[i].cells[7].innerHTML = durasi(mulai, selesai);
			}
		}
		autoload();

		// Detail
		$('.btn-detail').on('click', function() {
			var detail = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>akuntan/proses_data_lainnya/detail',
				data: 'action='+ detail,
				success: function(data) {
					$("#detail").modal('show');
					$("#showDetail").html(data);
				}
			})
		});
	})
</script>


<div class="modal-header px-4">
	<h4 class="modal-title"><?= $judul ?></h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col">
				<p class="lead">
					<b>Pilih data yang akan dikirim</b>
				</p>
			</div>
		</div>
		
		<table class="table table-striped">
			<thead class="text-center">
				<tr>
					<th>No.</th>
					<th>Nama Data</th>
					<th>Detail</th>
					<th>Format Data</th>
					<th>Status</th>
					<th>Kirim</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php
					foreach($detail as $d => $val) : ?>
				<tr>
					<td><?=$d+1?>.</td>
					<td><?=$val['jenis_data']?></td>
					<td><?=$val['detail']?></td>
					<td><?=$val['format_data']?></td>
					<td><?=$badge[$d]?></td>
					<td class="icon-medium">
						<?php if($val['status_kirim'] != 'yes') : ?>
						<a href="<?=base_url($link.$val['id_data'])?>" data-toggle="tooltip" data-placement="bottom" title="Kirim Data">
							<i class="bi bi-cursor-fill"></i>
						</a>
						<?php endif; ?>
					</td>
				</tr>
					<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$('[data-toggle="tooltip"]').mouseover(function() {
		$(this).tooltip();
	});
</script>
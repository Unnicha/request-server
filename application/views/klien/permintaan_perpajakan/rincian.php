<table class="table mb-0">
	<thead>
		<tr style="background-color:white">
			<th>No.</th>
			<th>Jenis Data</th>
			<th>Keterangan</th>
			<th>Format Data</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($isi as $i => $val) : ?>
		<tr style="background-color:white">
			<td class="text-center"><?= $i+1 ?>.</td>
			<td><?= $val['jenis_data'] ?></td>
			<td><?= $val['detail'] ?></td>
			<td><?= $val['format_data'] ?></td>
			<td><?= $badge[$i] ?></td>
			<td style="font-size:18px; line-height:80%">
				<a href="<?=base_url('klien/permintaan_data_perpajakan/detail/'.$val['id_data'])?>" data-toggle="tooltip" data-placement="bottom" title="Lihat History Pengiriman">
					<i class="bi bi-search"></i>
				</a>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
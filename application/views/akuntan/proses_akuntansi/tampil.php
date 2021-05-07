<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item tab-proses" role="presentation">
		<a class="nav-link" id="belum-tab" data-toggle="tab" data-nilai="belum" href="#belum" role="tab" aria-controls="belum" aria-selected="false" style="color:black">Belum Diproses</a>
	</li>
	<li class="nav-item tab-proses" role="presentation">
		<a class="nav-link active" id="sedang-tab" data-toggle="tab" data-nilai="onproses" href="#sedang" role="tab" aria-controls="sedang" aria-selected="true" style="color:black">Sedang Diproses</a>
	</li>
	<li class="nav-item tab-proses" role="presentation">
		<a class="nav-link" id="sudah-tab" data-toggle="tab" data-nilai="selesai" href="#sudah" role="tab" aria-controls="sudah" aria-selected="false" style="color:black">Selesai Diproses</a>
	</li>
</ul>

<div class="tab-content container-proses" id="myTabContent">
	<div class="tab-pane fade" id="belum" role="tabpanel" aria-labelledby="belum-tab">belum</div>
	<div class="tab-pane fade show active" id="sedang" role="tabpanel" aria-labelledby="sedang-tab">onproses</div>
	<div class="tab-pane fade" id="sudah" role="tabpanel" aria-labelledby="sudah-tab">selesai</div>
</div>

<script>
	$(document).ready(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#sedang-tab').data('nilai')},
			url: '<?= base_url(); ?>akuntan/proses_data_akuntansi/proses',
			success: function(data) {
				$("#sedang").html(data);
			}
		})
	});
	$('#sedang-tab').click(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#sedang-tab').data('nilai')},
			url: '<?= base_url(); ?>akuntan/proses_data_akuntansi/proses',
			success: function(data) {
				$("#sedang").html(data);
			}
		})
	});
	$('#belum-tab').click(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#belum-tab').data('nilai')},
			url: '<?= base_url(); ?>akuntan/proses_data_akuntansi/prosesBelum',
			success: function(data) {
				$("#belum").html(data);
			}
		})
	});
	$('#sudah-tab').click(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#sudah-tab').data('nilai')},
			url: '<?= base_url(); ?>akuntan/proses_data_akuntansi/prosesSelesai',
			success: function(data) {
				$("#sudah").html(data);
			}
		})
	});
</script>

<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item tab-proses" role="presentation">
		<a class="nav-link" id="tab-belum" data-toggle="tab" data-nilai="belum" href="#belum" role="tab" aria-controls="belum" aria-selected="false" style="color:black">Belum Diproses</a>
	</li>
	<li class="nav-item tab-proses" role="presentation">
		<a class="nav-link active" id="tab-sedang" data-toggle="tab" data-nilai="onproses" href="#sedang" role="tab" aria-controls="sedang" aria-selected="true" style="color:black">Sedang Diproses</a>
	</li>
	<li class="nav-item tab-proses" role="presentation">
		<a class="nav-link" id="tab-selesai" data-toggle="tab" data-nilai="selesai" href="#sudah" role="tab" aria-controls="sudah" aria-selected="false" style="color:black">Selesai Diproses</a>
	</li>
</ul>


<div class="tab-content container-proses py-3" id="myTabContent">
	<div class="tab-pane fade" id="belum" role="tabpanel" aria-labelledby="tab-belum">belum</div>
	<div class="tab-pane fade show active" id="sedang" role="tabpanel" aria-labelledby="tab-sedang">onproses</div>
	<div class="tab-pane fade" id="sudah" role="tabpanel" aria-labelledby="tab-selesai">selesai</div>
</div>


<script>
	$(document).ready(function() {
		$('#menu4').collapse('show');

		$.ajax({
			type: 'POST',
			data: {'status': $('#tab-sedang').data('nilai')},
			url: '<?= base_url(); ?>admin/proses_data_perpajakan/proses',
			success: function(data) {
				$("#sedang").html(data);
			}
		})
	});
	$('#tab-sedang').click(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#tab-sedang').data('nilai')},
			url: '<?= base_url(); ?>admin/proses_data_perpajakan/proses',
			success: function(data) {
				$("#sedang").html(data);
			}
		})
	});
	$('#tab-belum').click(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#tab-belum').data('nilai')},
			url: '<?= base_url(); ?>admin/proses_data_perpajakan/prosesBelum',
			success: function(data) {
				$("#belum").html(data);
			}
		})
	});
	$('#tab-selesai').click(function() {
		$.ajax({
			type: 'POST',
			data: {'status': $('#tab-selesai').data('nilai')},
			url: '<?= base_url(); ?>admin/proses_data_perpajakan/prosesSelesai',
			success: function(data) {
				$("#sudah").html(data);
			}
		})
	});
</script>

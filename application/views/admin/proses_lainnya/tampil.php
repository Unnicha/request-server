<div class="container-fluid">
	<h2 class="mb-3" align=center><?=$judul?></h2>

	<div class="row form-inline mb-3">
		<label>Tampilan per</label>
		<select name="tampil" class="form-control ml-2" id="tampil">
			<option>Klien</option>
			<option>Akuntan</option>
		</select>
		<select name="akuntan" class="form-control ml-2" id="akuntan">
		</select>
	</div>

	<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-belum" data-toggle="tab" data-nilai="belum" href="#belum" role="tab" aria-controls="belum" aria-selected="false" style="color:black">Belum Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link active" id="tab-onproses" data-toggle="tab" data-nilai="onproses" href="#onproses" role="tab" aria-controls="onproses" aria-selected="true" style="color:black">Sedang Diproses</a>
		</li>
		<li class="nav-item tab-proses" role="presentation">
			<a class="nav-link" id="tab-selesai" data-toggle="tab" data-nilai="selesai" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false" style="color:black">Selesai Diproses</a>
		</li>
	</ul>


	<div class="tab-content container-proses py-3 mb-3" id="myTabContent">
		<div class="tab-pane fade" id="belum" role="tabpanel" aria-labelledby="tab-belum">belum</div>
		<div class="tab-pane fade show active" id="onproses" role="tabpanel" aria-labelledby="tab-onproses">onproses</div>
		<div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="tab-selesai">selesai</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('#menu4').collapse('show');

		function tampilan(jenis) {
			$.ajax({
				type	: 'POST',
				data	: { tampil : jenis, },
				url		: '<?= base_url(); ?>admin/proses_data_lainnya/gantiTampilan',
				success	: function(data) {
					$("#akuntan").html(data);
				}
			})
		}
		function view(status) {
			$.ajax({
				type: 'POST',
				data: {
					status	: status,
					tampil	: $('#tampil').val(),
					akuntan	: $('#akuntan').val(),
					},
				url: '<?= base_url(); ?>admin/proses_data_lainnya/prosesOn',
				success: function(data) {
					$('#'+status).html(data);
				}
			})
		}
		tampilan( $('#tampil').val() );
		view( $('#myTab li a.active').data('nilai') );

		$('#tampil').on('change', function() {
			var tampil = $(this).val();
			tampilan(tampil);
			view( $('#myTab li a.active').data('nilai') );
		});
		$('#akuntan').on('change', function() {
			var status = $('#myTab li a.active').data('nilai');
			view(status);
		});
		
		$('#tab-onproses').click(function() {
			var status = $(this).data('nilai');
			view(status);
		});
		$('#tab-belum').click(function() {
			var status = $(this).data('nilai');
			view(status);
		});
		$('#tab-selesai').click(function() {
			var status = $(this).data('nilai');
			view(status);
		});
	});
</script>

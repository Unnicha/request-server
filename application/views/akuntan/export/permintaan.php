<div class="content container-fluid">
	<h3 class="content-header pb-3"><?=$judul?></h3>
	
	<div class="row">
		<div class="col-lg-8">
			<form action="" method="post">
				<!-- Tahun -->
				<div class="form-group row">
					<label class="col-md-3 col-lg-2 col-form-label">Tahun</label>
					<div class="col-md">
						<select name="tahun" id="tahun" class="form-control" required>
							<?php for($i=date('Y'); $i>=2016; $i--) :
								$value	= (set_value('tahun')) ? set_value('tahun') : date('Y');
								$pilih	= ($i == $value) ? 'selected' : ''; ?>
								<option value="<?=$i?>" <?=$pilih?>><?=$i?></option>
							<?php endfor ?>
						</select>
						<small class="form-text text-danger"><?= form_error('tahun', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<!-- Bulan -->
				<div class="form-group row">
					<label class="col-md-3 col-lg-2 col-form-label">Bulan</label>
					<div class="col-md">
						<select name="bulan" id="bulan" class="form-control" required>
							<?php foreach ($bulan as $b) :
								$val	= (set_value('bulan')) ? set_value('bulan') : $this->session->userdata('bulan');
								$pilih	= ($b['id_bulan'] == $val) ? 'selected' : ''; ?>
								<option value="<?=$b['id_bulan']?>" <?=$pilih?>><?=$b['nama_bulan']?></option>
							<?php endforeach ?>
						</select>
						<small class="form-text text-danger"><?= form_error('bulan', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<!-- Kategori -->
				<div class="form-group row">
					<label class="col-md-3 col-lg-2 col-form-label">Kategori</label>
					<div class="col-md">
						<select name="kategori" id="kategori" class="form-control" required>
							<!-- <option value="">--Pilih Kategori--</option> -->
							<?php foreach ($kategori as $k) :
								$pilih = (set_value('kategori')) ? 'selected' : ''; ?>
								<option value="<?=strtolower($k)?>" <?=$pilih?>>Data <?=$k?></option>
							<?php endforeach ?>
						</select>
						<small class="form-text text-danger"><?= form_error('kategori', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<!-- Klien -->
				<div class="form-group row">
					<label class="col-md-3 col-lg-2 col-form-label">Klien</label>
					<div class="col-md">
						<select name="klien" id="klien" class="form-control">
						</select>
						<small class="form-text text-danger"><?= form_error('klien', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>
				
				<div class="row mt-4 text-right">
					<div class="col">
						<a class="btn btn-info btn-show">Tampilkan laporan</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div id="filename" class="d-none"></div>
	<div id="filetitle" class="d-none"></div>
	
	<div id="showLaporan" class="card card-round shadow mt-4 d-none">
		<div class="card-body">
			<table id="myTable" class="table table-striped" style="width:100%">
				<thead class="text-center">
					<tr>
						<th>No.</th>
						<th>Klien</th>
						<th>Permintaan</th>
						<th>Tanggal Permintaan</th>
						<th>Requestor</th>
						<th>Nama Data</th>
						<th>Detail</th>
						<th>Format</th>
						<th>Status</th>
						<th>Pengiriman Terakhir</th>
					</tr>
				</thead>
				
				<tbody class="text-center">
				</tbody>
			</table>
			
			<!-- <div class="row mt-4">
				<div class="col">
					<button type="submit" name="export" value="xls" class="btn btn-excel">
						<i class="bi bi-file-earmark-spreadsheet"></i>
						Export Excel
					</button>
					<button type="submit" name="export" value="pdf" class="btn btn-pdf">
						<i class="bi bi-file-earmark-pdf"></i>
						Export PDF
					</button>
				</div>
			</div> -->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/pdfmake.min.js"></script>
<script>
	$(document).ready(function() {
		function getKlien() {
			$.ajax({
				type	: 'post',
				url		: '<?=base_url()?>akuntan/export_permintaan/getKlien',
				data	: {
					'tahun'		: $('#tahun').val(),
					'bulan'		: $('#bulan').val(),
					'kategori'	: $('#kategori').val(),
				},
				success	: function (data) {
					$('#klien').html(data);
				},
			})
		}
		getKlien();
		
		function getFile() {
			$.ajax({
				type	: 'post',
				url		: '<?=base_url()?>akuntan/export_permintaan/filename',
				data	: {
					'tahun'		: $('#tahun').val(),
					'bulan'		: $('#bulan').val(),
					'kategori'	: $('#kategori').val(),
					'klien'		: $('#klien').val(),
				},
				success	: function (data) {
					var e = JSON.parse(data);
					$('#filename').html(e.filename);
					$('#filetitle').html(e.title);
				},
			});
		}
		
		$('#bulan').change(function() {
			getKlien();
			$('#showLaporan').addClass('d-none');
		})
		$('#tahun').change(function() {
			getKlien();
			$('#showLaporan').addClass('d-none');
		})
		$('#kategori').change(function() {
			getKlien();
			$('#showLaporan').addClass('d-none');
		})
		$('#klien').change(function() {
			$('#showLaporan').addClass('d-none');
		})
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'responsive'	: true,
			'paging'		: false,
			'ordering'		: false,
			'searching'		: false,
			'lengthChange'	: false,
			'dom'			: 'Bfrtip',
			'buttons'		: [
				{
					extend: 'excel',
					text: 'Export Excel',
					title: function() { return $('#filetitle').html() },
					filename: function() { return $('#filename').html() },
				},
				{
					extend: 'pdf',
					text: 'Export PDF',
					orientation: 'landscape',
					title: function() { return $('#filetitle').html() },
					filename: function() { return $('#filename').html() },
					customize: function (doc) {
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear()+' '+now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
						// doc.defaultStyle.fontSize = 7;
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Created on: ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
									}
								],
								margin: 20
							}
						});
					}
				},
				{
					extend: 'print',
				},
			],
			'language'		: {
				'emptyTable'	: "Tidak ada permintaan",
			},
			'ajax'		: {
				'url'	: '<?=base_url()?>akuntan/export_permintaan/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.tahun		= $('#tahun').val();
					e.bulan		= $('#bulan').val();
					e.klien		= $('#klien').val();
					e.kategori	= $('#kategori').val();
				},
			},
		});
		
		$('.btn-show').on('click', function() {
			getFile();
			$('#showLaporan').removeClass('d-none');
			table.draw();
		})
	})
</script>
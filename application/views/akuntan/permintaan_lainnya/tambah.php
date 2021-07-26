<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<!-- Judul Form -->
			<h3><?= $judul; ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child my-3">
		<div class="col">
			<form action="" method="post">
				<input type="hidden" name="id_user" value="<?=$this->session->userdata('id_user')?>">
				
				<!-- Klien -->
				<div class="form-group row">
					<label for="id_klien" class="col-sm-4 col-form-label">Nama Klien</label> 
					<div class="col-sm col-md-4 p-0">
						<select name='id_klien' class="form-control" id="id_klien" required>
						</select>
					</div>
				</div>
				
				<div class="row px-3">
					<h6 class="mb-0">Data :</h6>
				</div>
				
				<!-- Data -->
				<div class="data px-3 mt-3">
					<div class="add-after mb-3">
						<div class="form-row">
							<div class="col">
								<div class="form-row">
									<!-- Jenis Data -->
									<div class="col-sm">
										<select name="kode_jenis[]" class="form-control" required>
											<option value="" selected>--Pilih Jenis Data--</option>
												<?php foreach ($jenis as $j) : ?>
											<option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
												<?php endforeach ?>
										</select>
									</div>
									
									<!-- Keterangan -->
									<div class="col-sm">
										<input type="text" name="detail[]" class="form-control" placeholder="Detail">
									</div>
									
									<!-- Format Data -->
									<div class="col-sm">
										<select name="format_data[]" class="form-control" required>
											<option value="" selected>--Pilih Format Data--</option>
											<option value="Softcopy">Softcopy</option>
											<option value="Hardcopy">Hardcopy</option>
										</select>
									</div>
								</div>
							</div>
							<div class="span py-1">
								<a class="btn btn-sm btn-success add-data" data-toggle="tooltip" data-placement="bottom" title="Tambah">
									<i class="bi bi-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">Kirim</button>
						<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</form>
			
			<!-- Add Data -->
			<div class="clone invisible">
				<div class="control-group mb-3">
					<div class="form-row">
						<div class="col">
							<div class="form-row">
								<!-- Jenis Data -->
								<div class="col-sm">
									<select name="kode_jenis[]" class="form-control" required>
										<option value="" selected>--Pilih Jenis Data--</option>
											<?php foreach ($jenis as $j) : ?>
										<option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
											<?php endforeach ?>
									</select>
								</div>
								
								<!-- Keterangan -->
								<div class="col-sm">
									<input type="text" name="detail[]" class="form-control" placeholder="Detail">
								</div>
								
								<!-- Format Data -->
								<div class="col-sm">
									<select name="format_data[]" class="form-control" required>
										<option value="" selected>--Pilih Format Data--</option>
										<option value="Softcopy">Softcopy</option>
										<option value="Hardcopy">Hardcopy</option>
									</select>
								</div>
							</div>
						</div>
						<div class="span py-1">
							<a class="btn btn-sm btn-outline-danger remove-data" data-toggle="tooltip" data-placement="bottom" title="Hapus">
								<i class="bi bi-trash"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.data').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		});
		
		function getKlien() {
			$.ajax({
				type	: 'POST',
				url		: '<?=base_url()?>akuntan/permintaan_data_lainnya/klien',
				data	: {jenis : 'Pilih'},
				success	: function(e) {
					$('#id_klien').html(e);
				}
			})
		}
		getKlien();
		
		$(".add-data").click(function() {
			var html = $(".clone").html();
			$(".add-after").after(html);
		});
		
		// saat tombol remove dklik control group akan dihapus
		$("body").on("click", ".remove-data", function() {
			$(this).parents(".control-group").remove();
		});
	})
</script>
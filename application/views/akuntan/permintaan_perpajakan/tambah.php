<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<!-- Judul Form -->
			<h3><?= $judul; ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child my-4">
		<div class="col">
			<form action="" method="post">
				<input type="hidden" name="id_user" value="<?=$this->session->userdata('id_user')?>">
				<input type="hidden" name="bulan" value="<?=date('m')?>">
				<input type="hidden" name="tahun" value="<?=date('Y')?>">
				
				<div class="col-tambah">
					<!-- Klien -->
					<div class="form-group row">
						<label for="id_klien" class="col-sm-4 col-form-label">Klien</label> 
						<div class="col-sm">
							<select name='id_klien' class="form-control" id="id_klien" required>
							</select>
						</div>
					</div>
				</div>
				
				<div class="row px-3">
					<h6 class="mb-0">Data</h6>
				</div>
				<hr class="m-3">
				<div class="data px-4">
					<div class="add-after mb-3">
						<div class="form-row">
							<div class="col">
								<div class="form-row">
									<!-- Jenis Data -->
									<div class="col-md">
										<select name="kode_jenis[]" class="form-control" required>
											<option value="" selected>--Pilih Jenis Data--</option>
												<?php foreach ($jenis as $j) : ?>
											<option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
												<?php endforeach ?>
										</select>
									</div>
									
									<!-- Keterangan -->
									<div class="col-md">
										<input type="text" name="detail[]" class="form-control" placeholder="Detail">
									</div>
									
									<!-- Format Data -->
									<div class="col-md">
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
						<button type="submit" name="tambah" class="btn btn-primary mr-1">
							Kirim
						</button>
						<a href="<?= base_url(); ?>akuntan/permintaan_data_perpajakan" class="btn btn-secondary">
							Batal
						</a>
					</div>
				</div>
			</form>
			
			<div class="clone invisible">
				<div class="control-group mb-3">
					<div class="form-row">
						<div class="col">
							<div class="form-row">
								<!-- Jenis Data -->
								<div class="col-md">
									<select name="kode_jenis[]" class="form-control" required>
										<option value="" selected>--Pilih Jenis Data--</option>
											<?php foreach ($jenis as $j) : ?>
										<option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
											<?php endforeach ?>
									</select>
								</div>
								
								<!-- Keterangan -->
								<div class="col-md">
									<input type="text" name="detail[]" class="form-control" placeholder="Detail">
								</div>
								
								<!-- Format Data -->
								<div class="col-md">
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
				url		: '<?=base_url()?>akuntan/permintaan_data_perpajakan/klien',
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
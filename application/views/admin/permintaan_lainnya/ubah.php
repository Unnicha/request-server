<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h4><?= $judul ?></h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card card-round card-shadow">
				<div class="card-body px-4">
					<form action="" method="post">
						<input type="hidden" name="id_user" value="<?=$this->session->userdata('id_user')?>">
						<input type="hidden" name="id_permintaan" value="<?=$permintaan['id_permintaan']?>">
						
						<!-- Klien -->
						<div class="form-group row">
							<label class="col-lg-2">Nama Klien</label> 
							<div class="col-lg-4">
								<input type="text" class="form-control" name='klien' value="<?=$permintaan['nama_klien']?>" readonly>
							</div>
						</div>
						
						<div class="form-group row mb-0">
							<label class="col-lg-2">Data</label>
							<div class="col data">
							<?php foreach($detail as $d => $val) : ?>
								<input type="hidden" name='id_data[]' value="<?=$val['id_data']?>">
								
								<div class="control-group add-after form-row mb-3">
									<div class="col">
										<div class="form-row">
											<!-- Jenis Data -->
											<div class="col-sm">
												<input type="text" class="form-control" nama="jenis_data[<?=$d?>]" value="<?=$val['jenis_data']?>" readonly>
											</div>
											
											<!-- Keterangan -->
											<div class="col-sm">
												<input type="text" class="form-control" name="detail[<?=$d?>]" placeholder="Detail" value="<?=$val['detail']?>"<?=($val['status_kirim'] == 'yes') ? 'readonly' : 'required';?>>
											</div>
											
											<!-- Format Data -->
											<div class="col-sm">
												<select class="form-control" name="format_data[<?=$d?>]">
													<?php if($val['status_kirim'] == 'yes') : ?>
													<option value="<?=$val['format_data']?>" readonly><?=$val['format_data']?></option>
													<?php else : ?>
													<option value="Softcopy" <?=($val['format_data'] == 'Softcopy') ? 'selected' : '';?>>Softcopy</option>
													<option value="Hardcopy" <?=($val['format_data'] == 'Hardcopy') ? 'selected' : '';?>>Hardcopy</option>
													<?php endif ?>
												</select>
											</div>
										</div>
									</div>
									<div class="span p-1">
										<?php if($val['status_kirim'] == 'yes') : ?>
										<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Data sudah dikonfirmasi">
											<i class="bi bi-check-lg"></i>
										</a>
										<?php else : ?>
										<a class="btn btn-sm btn-outline-danger remove-data" data-toggle="tooltip" data-placement="bottom" title="Hapus">
											<i class="bi bi-trash"></i>
										</a>
										<?php endif ?>
									</div>
								</div>
							<?php endforeach ?>
							</div>
						</div>
						
						<!-- Tombol Simpan -->
						<div class="row mt-3">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Ubah</button>
								<a href="javascript:location.reload()" class="btn btn-outline-secondary">Reset</a>
								<a href="<?=base_url('admin/permintaan/permintaan_data_lainnya')?>" class="btn btn-light">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<!-- Add Data -->
			<div class="clone invisible">
				<div class="control-group form-row mb-3">
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
								<input type="text" name="detail[]" class="form-control" placeholder="Detail" required>
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
					<div class="span p-1">
						<a class="btn btn-sm btn-outline-danger remove-data" data-toggle="tooltip" data-placement="bottom" title="Hapus">
							<i class="bi bi-trash"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').mouseover(function() {
			$(this).tooltip();
		});
		
		$(".add-data").click(function() {
			var html = $(".clone").html();
			$(".add-after:last-child").after(html);
			$('.data .control-group').addClass('add-after');
		});
		
		// saat tombol remove diklik control group akan dihapus
		$("body").on("click", ".remove-data", function() {
			$(this).parents(".control-group").remove();
		});
	})
</script>
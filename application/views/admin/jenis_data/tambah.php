<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h4>Tambah Jenis Data</h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-9">
			<div class="card card-round">
				<div class="card-body p-4">
					<form action="" method="post"> 
						<!-- Kategori -->
						<div class="form-group row">
							<label for="kategori" class="col-sm-3 col-form-label">Kategori</label> 
							<div class="col-sm">
								<select name='kategori' class="form-control" id="kategori" required>
									<option value="">-- Pilih Kategori --</option>
										<?php 
											$input = set_value('kategori');
											foreach ($kategori as $k => $val) : 
												if($val == $input) {
											$pilih = "selected";
												} else {
											$pilih = "";
												}
										?>
									<option <?=$pilih?>><?= $val; ?></option>
										<?php endforeach ?>
								</select>
								<small class="form-text text-danger"><?= form_error('kategori', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Jenis Data -->
						<div class="form-group row">
							<label for="jenis_data" class="col-sm-3 col-form-label">
								Jenis Data
							</label> 
							<div class="col-sm">
								<input type="text" name="jenis_data" class="form-control" id="jenis_data" placeholder="Masukkan Jenis Data"  value="<?= set_value('jenis_data') ?>" required>
								<small class="form-text text-danger"><?= form_error('jenis_data', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Actions -->
						<div class="row mt-3 text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
								<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> 
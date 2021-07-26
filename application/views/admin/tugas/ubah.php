<div class="container">
	<div class="row row-child mt-2">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<!-- Isi Form -->
	<form action="" method="post"> 
		<div class="row row-child my-4">
			<div class="col col-tambah">
				<input type="hidden" name="kode_tugas" id="kode_tugas" value="<?=$tugas['kode_tugas']?>">
				<input type="hidden" name="kode_jenis" id="kode_jenis" value="<?=$tugas['kode_jenis']?>">
				
				<!-- Nama Tugas -->
				<div class="form-group row">
					<label for="nama_tugas" class="col-sm-4 col-form-label">
						Nama Tugas
					</label> 
					<div class="col-sm">
						<input type="text" name="nama_tugas" class="form-control" id="nama_tugas" value="<?= set_value('nama_tugas') ? set_value('nama_tugas') : $tugas['nama_tugas']?>" required>
						<small class="form-text text-danger"><?= form_error('nama_tugas', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Jenis Data -->
				<div class="form-group row">
					<label for="jenis_data" class="col-sm-4 col-form-label">
						Jenis Data
					</label> 
					<div class="col-sm">
						<input type="text" name="jenis_data" class="form-control" id="jenis_data" value="<?= $tugas['jenis_data']?>" readonly>
					</div>
				</div>
				
				<!-- Lama Pengerjaan -->
				<div class="form-group row">
					<div class="col py-2"><b>Lama Pengerjaan</b></div>
				</div>
				
				<!-- Accounting Service -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">
						Accounting Service
					</label> 
					<div class="col-sm">
						<div class="row">
							<div class="col px-0 input-group">
								<input type="number" name="hari[]" class="form-control" min="0" value="<?= set_value('hari[0]') ? set_value('hari[0]') : $hari[0]?>" required>
								<div class="input-group-append">
									<span class="input-group-text rounded-right"> hari </span>
								</div>
							</div>
							<div class="col pl-2 pr-0 input-group">
								<input type="number" name="jam[]" class="form-control" min="0" max="7" value="<?= set_value('jam[0]') ? set_value('jam[0]') : $jam[0]?>" required>
								<div class="input-group-append">
									<span class="input-group-text rounded-right"> jam </span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Review -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">
						Review
					</label> 
					<div class="col-sm">
						<div class="row">
							<div class="col px-0 input-group">
								<input type="number" name="hari[]" class="form-control" min="0" value="<?= set_value('hari[1]') ? set_value('hari[1]') : $hari[1]?>" required>
								<div class="input-group-append">
									<span class="input-group-text rounded-right"> hari </span>
								</div>
							</div>
							<div class="col pl-2 pr-0 input-group">
								<input type="number" name="jam[]" class="form-control" min="0" max="7" value="<?= set_value('jam[1]') ? set_value('jam[1]') : $jam[1]?>" required>
								<div class="input-group-append">
									<span class="input-group-text rounded-right"> jam </span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Semi Review -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">
						Semi Review
					</label> 
					<div class="col-sm">
						<div class="row">
							<div class="col px-0 input-group">
								<input type="number" name="hari[]" class="form-control" min="0" value="<?= set_value('hari[2]') ? set_value('hari[2]') : $hari[2]?>" required>
								<div class="input-group-append">
									<span class="input-group-text rounded-right"> hari </span>
								</div>
							</div>
							<div class="col pl-2 pr-0 input-group">
								<input type="number" name="jam[]" class="form-control" min="0" max="7" value="<?= set_value('jam[2]') ? set_value('jam[2]') : $jam[2]?>" required>
								<div class="input-group-append">
									<span class="input-group-text rounded-right"> jam </span>
								</div>
							</div>
						</div>
						<small class="form-text">Format Jam Kerja (1 hari = 8 jam)</small>
					</div>
				</div>

				<div class="row mt-5">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
						<a href="javascript:history.go(-1)" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div> 
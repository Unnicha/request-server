<div class="content container-fluid">
	<div class="card card-round card-shadow">
		<div class="card-body p-4">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<h3 class="mb-3 text-center"><?= $judul ?></h3>
					
					<form action="" method="post" id='myForm'>
						<input type="hidden" name="level" id="level" value="<?=$level?>">
						
						<div id="tabs">
							<div class="add-klien ">
								<h5 class="mb-3">Info Akun</h5>
								
								<!-- Nama Klien -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="nama_klien" id="namaKlien" class="form-control" placeholder="Nama Klien" data-cek="required" value="<?= set_value('nama_klien') ?>" autofocus>
										<small class="form-text text-danger" id="error_namaKlien"></small>
									</div>
								</div>
								
								<!-- Username -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="username" id="username" class="form-control" placeholder="Username" data-cek="required|minLength-8|unique-user.username" value="<?= set_value('username') ?>">
										<small class="form-text text-danger" id="error_username"></small>
									</div>
								</div>
								
								<!-- Password -->
								<div class="form-group row">
									<div class="col">
										<input type="password" name="password" id="password" class="form-control" placeholder="Password" data-cek="required|minLength-8" value="<?= set_value('password') ?>">
										<small class="form-text text-danger" id="error_password"></small>
									</div>
								</div>
								
								<!-- Konfirmasi -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="password" name="passconf" id="passconf" class="form-control" placeholder="Konfirmasi Password" data-cek="required|matches-password" value="<?= set_value('passconf') ?>">
										<small class="form-text text-danger" id="error_passconf"></small>
									</div>
								</div>
							</div>
							
							<div class="add-klien ">
								<h5 class="mb-3">Info Perusahaan</h5>
								
								<!-- Nama Usaha -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="nama_usaha" class="form-control" id="namaUsaha" placeholder="Nama Usaha" data-cek="required" value="<?= set_value('nama_usaha') ?>">
										<small class="form-text text-danger" id="error_namaUsaha"></small>
									</div>
								</div>
								
								<!-- Kode KLU -->
								<div class="form-group row">
									<div class="col-sm">
										<div class="input-group">
											<select name='kode_klu' class="selectpicker form-control" data-size="6" data-live-search="true" id="kodeKlu" data-cek="select" placeholder="Kode KLU">
												<option value="">Pilih Kode KLU</option>
												<?php
													foreach ($klu as $k) : 
														$pilih = ($k['kode_klu'] == set_value('kode_klu')) ? "selected" : "";
													?>
												<option value="<?= $k['kode_klu'] ?>" <?=$pilih;?>>
													<?= $k['kode_klu'] ?> - <?=$k['bentuk_usaha']?> - <?=$k['jenis_usaha']?>
												</option>
												<?php endforeach ?>
											</select>
										</div>
										<small class="form-text text-danger" id="error_kodeKlu"></small>
									</div>
								</div>
								
								<!-- Bentuk Usaha -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="bentuk_usaha" class="form-control" id="bentukUsaha" placeholder="Bentuk Usaha" value="<?= set_value('bentuk_usaha') ?>" data-cek="" readonly>
										<small class="form-text text-danger" id="error_bentukUsaha"></small>
									</div>
								</div>
						
								<!-- Jenis Usaha -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="jenis_usaha" class="form-control" id="jenisUsaha" placeholder="Jenis Usaha" value="<?= set_value('jenis_usaha') ?>" data-cek="" readonly>
										<small class="form-text text-danger" id="error_jenisUsaha"></small>
									</div>
								</div>
						
								<!-- No. Akte Terakhir -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="no_akte" class="form-control number" id="noAkte" placeholder="Nomor Akte" data-cek="required" value="<?= set_value('no_akte') ?>">
										<small class="form-text text-danger" id="error_noAkte"></small>
									</div>
								</div>
						
								<!-- Status Pekerjaan -->
								<div class="form-group row">
									<div class="col-sm">
										<div class="input-group">
											<select name='status_pekerjaan' class="form-control" id="statusKerja" placeholder="Status Pekerjaan" data-cek="required">
												<option value="">Pilih Status Pekerjaan</option>
												<?php 
													foreach($status_pekerjaan as $stat) : 
														$pilih = ($stat == set_value('alamat')) ? 'selected' : '';
													?>
												<option value="<?=$stat?>" <?=$pilih?>><?=$stat?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<small class="form-text text-danger" id="error_statusKerja"></small>
									</div>
								</div>
							
								<!-- No. Telepon -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="telp" class="form-control phone" id="telp" placeholder="Nomor Telepon" data-cek="required|minLength-11" maxlength="13" value="<?= set_value('telp') ?>">
										<small class="form-text text-danger" id="error_telp"></small>
									</div>
								</div>
								
								<!-- No. HP -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="no_hp" class="form-control phone" id="noHp" placeholder="No. HP" data-cek="required|minLength-11" maxlength="13" value="<?= set_value('no_hp') ?>">
										<small class="form-text text-danger" id="error_noHp"></small>
									</div>
								</div>
								
								<!-- Email -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="email" class="form-control email" id="email" placeholder="Email" data-cek="required|email|unique-user.email_user" value="<?= set_value('email') ?>">
										<small class="form-text text-danger" id="error_email"></small>
									</div>
								</div>
								
								<!-- Alamat -->
								<div class="form-group row">
									<div class="col-sm">
										<textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat" data-cek="required"><?= set_value('alamat') ?></textarea>
										<small class="form-text text-danger" id="error_alamat"></small>
									</div>
								</div>
							</div>
							
							<div class="add-klien ">
								<h5 class="mb-3">Pimpinan</h5>
								
								<!-- Nama Pimpinan -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="nama_pimpinan" id="namaPim" class="form-control" placeholder="Nama Pimpinan" data-cek="required" value="<?= set_value('nama_pimpinan') ?>">
										<small class="form-text text-danger" id="error_namaPim"></small>
									</div>
								</div>
								
								<!-- Jabatan -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Jabatan" data-cek="required" value="<?= set_value('jabatan') ?>">
										<small class="form-text text-danger" id="error_jabatan"></small>
									</div>
								</div>
	
								<!-- No. HP Pimpinan -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="no_hp_pimpinan" id="phonePim" class="form-control phone" placeholder="Nomor HP" data-cek="required|minLength-11" maxlength="13" value="<?= set_value('no_hp_pimpinan') ?>">
										<small class="form-text text-danger" id="error_phonePim"></small>
									</div>
								</div>
								
								<!-- Email Pimpinan -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="email_pimpinan" id="emailPim" class="form-control email" placeholder="Email" data-cek="required|email" value="<?= set_value('email_pimpinan') ?>">
										<small class="form-text text-danger" id="error_emailPim"></small>
									</div>
								</div>
							</div>
							
							<div class="add-klien ">
								<h5 class="mb-3">Counterpart</h5>
								
								<!-- Nama Counterpart -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="nama_counterpart" id="namaCp" class="form-control" placeholder="Nama Counterpart" data-cek="required" value="<?= set_value('nama_counterpart') ?>">
										<small class="form-text text-danger" id="error_namaCp"></small>
									</div>
								</div>
								
								<!-- No. HP Counterpart -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="no_hp_counterpart" id="phoneCp" class="form-control phone" placeholder="Nomor HP" data-cek="required|minLength-11" maxlength="13" value="<?= set_value('no_hp_counterpart') ?>">
										<small class="form-text text-danger" id="error_phoneCp"></small>
									</div>
								</div>
								
								<!-- Email Counterpart -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="email_counterpart" id="emailCp" class="form-control email" placeholder="Email" data-cek="required|email" value="<?= set_value('email_counterpart') ?>">
										<small class="form-text text-danger" id="error_emailCp"></small>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-auto">
								<a href="<?=base_url()?>admin/master/klien" class="btn btn-secondary" tabindex="-1">Batal</a>
							</div>
							
							<div class="col text-right">
								<button type="button" class="btn btn-secondary prevBtn d-none" tabindex="-1">Kembali</button>
								<button type="button" class="btn btn-primary nextBtn">Berikutnya</button>
								<button type="button" class="btn btn-primary submitBtn">Simpan</button>
							</div>
						</div>
						
						<!-- Tabs Indikator -->
						<div class="indicator text-center mt-3">
							<span class="step"></span>
							<span class="step"></span>
							<span class="step"></span>
							<span class="step"></span>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
</div>


<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/jquery.inputmask.js"></script>
<!-- <script type="text/javascript" src="<?= base_url(); ?>asset/js/add-klien.js"></script> -->
<script>
	$(document).ready(function() {
		$('.number').inputmask({
			mask: '9{10,20}',
			showMaskOnHover: false,
			showMaskOnFocus: false,
		});
		$('.phone').inputmask({
			mask: '9{11,13}',
			showMaskOnHover: false,
			showMaskOnFocus: false,
		});
	})
	
	$('#kodeKlu').on('change', function() {
		var kode = $(this).find(':selected').val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url(); ?>admin/master/klien/pilih_klu',
			data: 'action='+ kode,
			success: function(data) {
				var json = data,
				obj = JSON.parse(json);
				$('#bentukUsaha').val(obj.bentuk_usaha);
				$('#jenisUsaha').val(obj.jenis_usaha);
			}
		})
	});
	
	var currentTab = 1;
	showTab(1);
	
	$('.nextBtn').click(function() {
		nextTab(1);
	})
	$('.prevBtn').click(function() {
		nextTab(-1);
	})
	
	function nextTab(n) {
		$('.form-control').removeClass('has_error');
		if(n == 1 && validation() == false ) {
			return false;
		} else {
			$('.form-group').removeClass('form-active');
			$('.add-klien').removeClass('active');
			currentTab = currentTab + n;
			if(currentTab <= $('.add-klien').length) {
				showTab(currentTab);
			}
		}
		showTab(currentTab);
	}
	
	function showTab(n) {
		$('.add-klien:nth-child('+n+')').addClass('active');
		$('.add-klien.active .form-group').addClass('form-active');
		if(currentTab > 1) {
			$('.prevBtn').removeClass('d-none');
		} else {
			$('.prevBtn').addClass('d-none');
		}
		if(currentTab >= $('.add-klien').length) {
			$('.nextBtn').addClass('d-none');
			$('.submitBtn').show().attr('type', 'submit');
		} else {
			$('.nextBtn').removeClass('d-none')
			$('.submitBtn').attr('type', 'button').hide();
		}
		indicator(n);
	}
	
	function indicator(n) {
		$('.step').removeClass('active');
		for(var i=1; i<=n; i++) {
			$('.step:nth-child('+i+')').addClass('active');
		}
	}
	
	function validation() {
		var result		= true;
		
		for(var i=1; i <= $('.form-active').length; i++) {
			var field	= $('.form-active:nth-of-type('+i+') .form-control');
			var id		= field.attr('id');
			var front	= field.attr('placeholder');
			var cek		= field.data('cek');
			var val		= $('#'+id).val();
			
			var errorMsg = '';
			if(cek != null) {
				cek = cek.split('|');
				for(x=0; x<cek.length; x++) {
					if( cek[x] == "required" ) {
						errorMsg = valRequired( val, front );
					} 
					else if( cek[x].includes("minLength") ) {
						var arr = cek[x].split("-");
						errorMsg = valMinLength( val, arr[1], front );
					} 
					else if( cek[x].includes("matches") ) {
						var arr = cek[x].split("-");
						errorMsg = valMatches( val, arr[1], front );
					} 
					else if( cek[x].includes("unique") ) {
						var arr = cek[x].split("-");
						var result = valUnique( val, arr[1], front );
						if(result == 'false') {
							errorMsg = front + ' sudah digunakan!';
						}
					}
					else if( cek[x] == "select" ) {
						val = $('#'+id).find(':selected').val();
						errorMsg = valRequired( val, front );
					} else if( cek[x] == "email") {
						errorMsg = valEmail( val );
					}
					
					if($.trim(errorMsg) != '') {
						field.addClass('has-error');
						result = false;
						break;
					} else {
						field.removeClass('has-error');
					}
				}
				$('#error_'+id).text(errorMsg);
			}
		}
		return result;
	}
	
	function valRequired(val, front) {
		if($.trim( val ).length == 0) {
			return front +' harus diisi!';
		}
		return '';
	}
	function valMinLength(val, min, front) {
		if( $.trim( val ).length < min ) {
			return front + ' minimal '+ min +' karakter!';
		}
		return '';
	}
	function valMatches(val, pair, front) {
		if( val != $('#'+pair).val() ) {
			return front + ' tidak sesuai!';
		}
		return '';
	}
	function valEmail(val) {
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(filter.test(val) == false) {
			return 'Format email salah!';
		}
		return '';
	}
	function valUnique(val, pair, front) {
		pair = pair.split(".");
		var hasil = $.ajax({
			url		: '<?=base_url()?>admin/master/klien/cekUnique',
			type	: 'post',
			dataType: 'json',
			async	: false,
			data	: {
				'value'	: val,
				'table'	: pair[0],
				'field'	: pair[1],
			},
			success	: function (e) {
				
			},
		}).responseText;
		return hasil;
	}
</script>
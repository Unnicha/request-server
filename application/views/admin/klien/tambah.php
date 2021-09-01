<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h4><?= $judul ?></h4>
		</div>
	</div>
	
	<div class="card card-round">
		<div class="card-body p-4">
			<form action="" method="post">
				<input type="hidden" name="level" id="level" value="<?=$level?>">
				
				<div id="tabs">
					<div class="add-klien ">
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
								<h5 class="mb-3">Info Akun</h5>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
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
						</div>
					</div>
					
					<div class="add-klien ">
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
								<h5 class="mb-3">Info Perusahaan</h5>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
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
											<select name='kode_klu' class="selectpicker form-control" data-size="6" data-live-search="true" id="kodeKlu" placeholder="Kode KLU" data-cek="required">
												<option value="">Pilih Kode KLU</option>
												<?php
													foreach ($klu as $k) : 
														if($k['kode_klu'] == set_value('kode_klu')) {
															$pilih = "selected";
														} else {
															$pilih = "";
														} ?>
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
									</div>
								</div>
						
								<!-- Jenis Usaha -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="jenis_usaha" class="form-control" id="jenisUsaha" placeholder="Jenis Usaha" value="<?= set_value('jenis_usaha') ?>" data-cek="" readonly>
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
											<select name='status_pekerjaan' class="form-control" data-live-search="true" id="statusKerja" placeholder="Status Pekerjaan" data-cek="required">
												<option value="">Pilih Status Pekerjaan</option>
												<?php foreach($status_pekerjaan as $stat) : ?>
												<option value="<?=$stat?>"><?=$stat?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<small class="form-text text-danger" id="error_statusKerja"></small>
									</div>
								</div>
							
								<!-- No. Telepon -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="telp" class="form-control telp" id="telp" placeholder="Nomor Telepon" data-cek="required" value="<?= set_value('telp') ?>">
										<small class="form-text text-danger" id="error_telp"></small>
									</div>
								</div>
								
								<!-- No. HP -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="no_hp" class="form-control phone" id="noHp" placeholder="No. HP" data-cek="required" value="<?= set_value('no_hp') ?>">
										<small class="form-text text-danger" id="error_noHp"></small>
									</div>
								</div>
								
								<!-- Email -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="email" class="form-control email" id="email" placeholder="Email" data-cek="required|unique-user.email_user" value="<?= set_value('email') ?>">
										<small class="form-text text-danger" id="error_email"></small>
									</div>
								</div>
								
								<!-- Alamat -->
								<div class="form-group row">
									<div class="col-sm">
										<textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat" data-cek="required" value="<?= set_value('alamat') ?>"></textarea>
										<small class="form-text text-danger" id="error_alamat"></small>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="add-klien ">
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
								<h5 class="mb-3">Pimpinan</h5>
								
								<!-- Nama Pimpinan -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="nama_pimpinan" class="form-control" placeholder="Nama Pimpinan" value="<?= set_value('nama_pimpinan') ?>">
										<small class="form-text text-danger">
										<?= form_error('nama_pimpinan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- Jabatan -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="<?= set_value('jabatan') ?>">
										<small class="form-text text-danger">
										<?= form_error('jabatan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
	
								<!-- No. HP Pimpinan -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="no_hp_pimpinan" class="form-control" placeholder="Nomor HP" value="<?= set_value('no_hp_pimpinan') ?>">
										<small class="form-text text-danger">
										<?= form_error('no_hp_pimpinan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- Email Pimpinan -->
								<div class="form-group row">
									<div class="col-sm">
										<input type="text" name="email_pimpinan" class="form-control" placeholder="Email" value="<?= set_value('email_pimpinan') ?>">
										<small class="form-text text-danger">
										<?= form_error('email_pimpinan', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="add-klien ">
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
								<h5 class="mb-3">Counterpart</h5>
								
								<!-- Nama Counterpart -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="nama_counterpart" class="form-control" placeholder="Nama Counterpart" value="<?= set_value('nama_counterpart') ?>">
										<small class="form-text text-danger">
										<?= form_error('nama_counterpart', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- No. HP Counterpart -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="no_hp_counterpart" class="form-control" placeholder="Nomor HP" value="<?= set_value('no_hp_counterpart') ?>">
										<small class="form-text text-danger">
										<?= form_error('no_hp_counterpart', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
								
								<!-- Email Counterpart -->
								<div class="form-group row">
									<div class="col">
										<input type="text" name="email_counterpart" class="form-control" placeholder="Email" value="<?= set_value('email_counterpart') ?>">
										<small class="form-text text-danger">
										<?= form_error('email_counterpart', '<p class="mb-0">', '</p>') ?>
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row text-right">
					<div class="col-lg-8 offset-lg-2">
						<button type="button" class="btn btn-secondary prevBtn d-none">Kembali</button>
						<button type="button" class="btn btn-primary nextBtn">Berikutnya</button>
						<!-- <button type="submit" class="btn btn-primary d-none">Simpan</button> -->
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
	<div class="row">
		<div class="col">
		</div>
	</div>
</div>


<script type="text/javascript" src="<?= base_url(); ?>asset/js/select.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/jquery.inputmask.js"></script>
<script>
	$(document).ready(function() {
		$('.number').inputmask('numeric', {
			rightAlign: false,
			showMaskOnHover: false,
			showMaskOnFocus: false,
		});
		$('.telp').inputmask('999-99999[9]', {
			showMaskOnHover: false,
			showMaskOnFocus: false,
		});
		$('.phone').inputmask('9999-9999-9999[9]', {
			showMaskOnHover: false,
			showMaskOnFocus: false,
		})
		$('.email').inputmask({
			mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}.*{2,10}[.*{2,5}]",
			showMaskOnHover: false,
			showMaskOnFocus: false,
			// greedy: false,
			// onBeforePaste: function (pastedValue, opts) {
			// 	pastedValue = pastedValue.toLowerCase();
			// 	return pastedValue.replace("mailto:", "");
			// },
			// definitions: {
			// 	'*': {
			// 		validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
			// 		casing: "lower"
			// 	}
			// }
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
	
	function showTab(n) {
		$('.add-klien:nth-child('+n+')').addClass('active');
		$('.add-klien.active .form-group').addClass('form-active');
		indicator(n);
		if(currentTab != 1) {
			$('.prevBtn').removeClass('d-none');
		}
	}

	function indicator(n) {
		$('.step:nth-child('+n+')').addClass('active');
	}
	
	function nextTab(n) {
		$('.form-control').removeClass('has_error');
		if(n == 1 && validation() == false) {
			return false;
		} else {
			$('.add-klien:nth-child('+currentTab+')').removeClass('active');
			currentTab = currentTab + n;
			if(currentTab <= $('.add-klien').length) {
				showTab(currentTab);
			}
		}
		showTab(currentTab);
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
				// var hasil = JSON.parse(e);
				// return hasil;
			},
		}).responseText;
		return hasil;
	}
	
	// REAL TIME VALIDATION VER.
	// $('.form-control').on('focusout', function() {
	// 	$(this).addClass('form-active');
	// 	var id	= $(this).attr('id');
	// 	var cek	= validation();
	// 	if(cek[0] == false) {
	// 		$(this).addClass('has-error');
	// 	} else {
	// 		$(this).removeClass('has-error');
	// 	}
	// 	$('#error_'+id).text(cek[1]);
	// 	$(this).removeClass('form-active');
	// 	if(id == 'password') {
	// 		$('#passconf').focus();
	// 	}
	// })
	
	// function validation() {
	// 	var status	= true;
	// 	var field	= $('.form-active');
	// 	var front	= field.attr('placeholder');
	// 	var cek		= field.data('cek');
	// 	var id		= field.attr('id');
	// 	var val		= $('#'+id).val();
	// 	var errorMsg = '';
		
	// 	if(cek != null) {
	// 		cek = cek.split('|');
	// 		for(x=0; x<cek.length; x++) {
	// 			if( cek[x] == "required" ) {
	// 				errorMsg = valRequired( val, front );
	// 			} 
	// 			else if( cek[x].includes("minLength") ) {
	// 				var arr = cek[x].split("-");
	// 				errorMsg = valMinLength( val, arr[1], front );
	// 			} 
	// 			else if( cek[x].includes("matches") ) {
	// 				var arr = cek[x].split("-");
	// 				errorMsg = valMatches( val, arr[1], front );
	// 			} 
	// 			else if( cek[x].includes("unique") ) {
	// 				var arr = cek[x].split("-");
	// 				var res = valUnique( val, arr[1], front );
	// 				if(res == 'false') {
	// 					errorMsg = front + ' sudah digunakan!';
	// 				}
	// 			}
				
	// 			if($.trim(errorMsg) != '') {
	// 				status = false;
	// 				break;
	// 			}
	// 		}
	// 	}
	// 	var result = [status, errorMsg];
	// 	return result;
	// }
</script>
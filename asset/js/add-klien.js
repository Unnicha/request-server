$(document).ready(function() {
	$('.number').inputmask('numeric', {
		rightAlign: false,
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
	if(n == 1 && validation() == false) {
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
		$('.submitBtn').hide();
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
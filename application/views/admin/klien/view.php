<div class="container-fluid mb-4">
	<!-- Trigger Modal -->
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	<?php if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->flashdata('tipe')?>"></div>
	<?php endif; ?>
	
	<h2 align="center"><?=$judul?></h2>
	<p class="subheader mb-2 text-center">
		Detail Info Akun, Usaha, Pimpinan dan Counterpart
	</p>
	
	<hr class="my-0 hr-profil">
	
	<div class="row row-child py-3 px-0 px-sm-4 mb-2">
		<div class="col px-0">
			<!-- Header Card -->
			<div class="row">
				<div class="col">
					<h5 class="card-title">Info Akun</h5>
				</div>
			</div>
			<!-- Isi Card -->
			<div class="row">
				<div class="col-4">ID Klien</div>
				<div class="col id_user"><?= $user['id_user'] ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nama Klien</div>
				<div class="col"><?= $user['nama'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="nama" data-input="user">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Email</div>
				<div class="col"><?= $user['email_user'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="email" data-input="user">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Username</div>
				<div class="col"><?= $user['username'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="username" data-input="user">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Password</div>
				<div class="col"><?= $user['passcode'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="password" data-input="user">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<hr class="my-0 hr-profil">
	
	<div class="row row-child py-3 px-0 px-sm-4 mb-2">
		<div class="col px-0">
			<!-- Header Card -->
			<div class="row">
				<div class="col"><h5 class="card-title">Info Usaha</h5></div>
				<div class="col">
					<a href="#" class="btn btn-sm btn-primary verif float-right" data-tipe="usaha" data-input="profil">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<!-- Isi Card -->
			<div class="row">
				<div class="col-4">Nama Usaha</div>
				<div class="col"><?= $user['nama_usaha']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Kode KLU</div>
				<div class="col"><?= $user['kode_klu']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Bentuk Usaha</div>
				<div class="col"><?= $user['bentuk_usaha']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Jenis Usaha</div>
				<div class="col"><?= $user['jenis_usaha']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Alamat</div>
				<div class="col"><?= $user['alamat']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nomor Telepon</div>
				<div class="col"><?= $user['telp']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nomor HP</div>
				<div class="col"><?= $user['no_hp']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nomor Akte Terakhir</div>
				<div class="col"><?= $user['no_akte']; ?></div>
			</div>
		</div>
	</div>
	
	<hr class="my-0 hr-profil">
	
	<div class="row row-child py-3 px-0 px-sm-4 mb-2">
		<div class="col px-0">
			<!-- Header Card -->
			<div class="row">
				<div class="col"><h5 class="card-title">Pimpinan</h5></div>
				<div class="col">
					<a href="#" class="btn btn-sm btn-primary verif float-right" data-tipe="pimpinan" data-input="profil">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<!-- Isi Card -->
			<div class="row">
				<div class="col-4">Nama Pimpinan</div>
				<div class="col"><?= $user['nama_pimpinan']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Jabatan</div>
				<div class="col"><?= $user['jabatan']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Email Pimpinan</div>
				<div class="col"><?= $user['email_pimpinan']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nomor HP Pimpinan</div>
				<div class="col"><?= $user['no_hp_pimpinan']; ?></div>
			</div>
		</div>
	</div>
	
	<hr class="my-0 hr-profil">
	
	<div class="row row-child py-3 px-0 px-sm-4 mb-2">
		<div class="col px-0">
			<!-- Header Card -->
			<div class="row">
				<div class="col"><h5 class="card-title">Counterpart</h5></div>
				<div class="col">
					<a href="#" class="btn btn-sm btn-primary verif float-right" data-tipe="counterpart" data-input="profil">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<!-- Isi Card -->
			<div class="row">
				<div class="col-4">Nama Counterpart</div>
				<div class="col"><?= $user['nama_counterpart']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Email Counterpart</div>
				<div class="col"><?= $user['email_counterpart']; ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nomor HP Counterpart</div>
				<div class="col"><?= $user['no_hp_counterpart']; ?></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade modalVerif" tabindex="-1" aria-labelledby="modalVerifLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto showVerif">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		if($('.notification').data('val') == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		function verif(tipe,input) {
			$.ajax({
				type	: 'POST',
				data	: {
					type	: tipe,
					input	: input,
					id		: $('.id_user').html(),
					},
				url		: '<?= base_url(); ?>admin/master/klien/verification',
				success	: function(data) {
					$(".modalVerif").modal('show');
					$(".showVerif").html(data);
				}
			})
		}
		
		$('.verif').click(function() {
			verif($(this).data('tipe'), $(this).data('input'));
		})
		
		if($('.passVerif').data('val') == 'yes') {
			verif($('.passVerif').data('tipe'), $('.passVerif').data('input'));
			$('.salah').html('Password salah!');
		}
	})
</script>

<div class="container-fluid mb-4">
	<!-- Trigger Modal -->
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	<?php if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->userdata('tipe')?>"></div>
	<?php endif; ?>
	
	<div class="row row-child">
		<div class="col">
			<h2 class="text-center mb-2"><?=$judul?></h2>
		</div>
	</div>
	
	<hr class="my-0 hr-profil">
	
	<div class="row row-child py-3 px-4">
		<div class="col mb-2">
			<!-- Header Card -->
			<div class="row">
				<div class="col">
					<h5 class="card-title mb-3">Info Akun</h5>
				</div>
			</div>
			
			<!-- Isi Card -->
			<div class="row">
				<div class="col-4">ID Akuntan</div>
				<div class="col"><?= $admin['id_user'] ?></div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Nama Akuntan</div>
				<div class="col"><?= $admin['nama'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="nama">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Email</div>
				<div class="col"><?= $admin['email_user'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="email">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Username</div>
				<div class="col"><?= $admin['username'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="username">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			<hr class="solid batas-profil">
			<div class="row">
				<div class="col-4">Password</div>
				<div class="col"><?= $admin['passcode'] ?></div>
				<div class="col">
					<a href="#" type="button" class="verif float-right" data-tipe="password">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<hr class="my-0 hr-profil">
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
		
		function verif(tipe) {
			$.ajax({
				type	: 'POST',
				data	: {
					type	: tipe,
					id		: '<?=$this->session->userdata('id_user');?>',
					},
				url		: '<?= base_url(); ?>admin/profile/verification',
				success	: function(data) {
					$(".modalVerif").modal('show');
					$(".showVerif").html(data);
				}
			})
		}
		
		$('.verif').click(function() {
			verif($(this).data('tipe'));
		})
		
		if($('.passVerif').data('val') == 'yes') {
			verif($('.passVerif').data('tipe'));
			$('.salah').html('Password salah!');
		}
	})
</script>

<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<?php if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->flashdata('tipe')?>"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h3>Profil Akuntan</h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card card-shadow">
				<div class="card-body">
					<!-- <h5 class="card-title mb-3">Info Akun</h5> -->
					<table class="table table-detail">
						<tr>
							<td class="detail-title">ID Akuntan</td>
							<td id="id_user"><?= $akuntan['id_user'] ?></td>
							<td></td>
						</tr>
						<tr>
							<td class="detail-title">Nama Akuntan</td>
							<td><?= $akuntan['nama'] ?></td>
							<td>
								<a type="button" class="verif float-right" data-tipe="nama">
									<i class="bi bi-pencil-square"></i>
									ganti
								</a>
							</td>
						</tr>
						<tr>
							<td class="detail-title">Email</td>
							<td><?= $akuntan['email_user'] ?></td>
							<td>
								<a type="button" class="verif float-right" data-tipe="email">
									<i class="bi bi-pencil-square"></i>
									ganti
								</a>
							</td>
						</tr>
						<tr>
							<td class="detail-title">Username</td>
							<td><?= $akuntan['username'] ?></td>
							<td>
								<a type="button" class="verif float-right" data-tipe="username">
									<i class="bi bi-pencil-square"></i>
									ganti
								</a>
							</td>
						</tr>
						<tr>
							<td class="detail-title">Password</td>
							<td><?= $akuntan['passcode'] ?></td>
							<td>
								<a type="button" class="verif float-right" data-tipe="password">
									<i class="bi bi-pencil-square"></i>
									ganti
								</a>
							</td>
						</tr>
					</table>
				</div>
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
		
		function verif(tipe) {
			$.ajax({
				type	: 'POST',
				data	: {
					type	: tipe,
					id		: '<?=$this->session->userdata('id_user');?>',
				},
				url		: '<?= base_url(); ?>akuntan/profile/verification',
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

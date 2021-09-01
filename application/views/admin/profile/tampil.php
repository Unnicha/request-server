<div class="content container-fluid">
	<!-- Trigger Modal -->
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif;
		if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->userdata('tipe')?>"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h2 class="text-center mb-2"><?=$judul?></h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card card-shadow">
				<div class="card-body p-4">
					<table class="table table-detail">
						<tbody>
							<tr>
								<td><b>ID</b></td>
								<td><?= $admin['id_user'] ?></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Nama Admin</b></td>
								<td><?= $admin['id_user'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="nama">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
							<tr>
								<td><b>Email</b></td>
								<td><?= $admin['email_user'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="email">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
							<tr>
								<td><b>Username</b></td>
								<td><?= $admin['username'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="username">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
							<tr>
								<td><b>Password</b></td>
								<td><?= $admin['passcode'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="password">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
						</tbody>
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

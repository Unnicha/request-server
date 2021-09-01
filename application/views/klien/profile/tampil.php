<div class="content container-fluid">
	<!-- Trigger Modal -->
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif ?>
	<?php if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->flashdata('tipe')?>"></div>
	<?php endif ?>
	
	<div class="content-header">
		<h3><?=$judul?></h3>
		<!-- <p class="subheader mb-2">
			Detail Info Akun, Usaha, Pimpinan dan Counterpart
		</p> -->
	</div>
	
	<div class="row mb-4">
		<div class="col">
			<div class="card card-shadow">
				<div class="card-body">
					<h5 class="card-title">Info Akun</h5>
					<table class="table table-detail mb-0">
						<div class="table-body">
							<tr>
								<td>ID Klien</td>
								<td><?= $klien['id_klien'] ?></td>
								<td></td>
							</tr>
							<tr>
								<td>Nama Klien</td>
								<td><?= $klien['nama'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="nama" data-input="user">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?= $klien['email_user'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="email" data-input="user">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
							<tr>
								<td>Username</td>
								<td><?= $klien['username'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="username" data-input="user">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
							<tr>
								<td>Password</td>
								<td><?= $klien['passcode'] ?></td>
								<td>
									<a href="#" type="button" class="verif float-right" data-tipe="password" data-input="user">
										<i class="bi bi-pencil-square"></i>
										ganti
									</a>
								</td>
							</tr>
						</div>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row mb-4">
		<div class="col">
			<div class="card card-shadow">
				<div class="card-body">
					<h5 class="card-title">Info Usaha</h5>
					<table class="table table-detail mb-0">
						<div class="table-body">
							<tr>
								<td>Nama Usaha</td>
								<td><?= $klien['nama_usaha'] ?></td>
							</tr>
							<tr>
								<td>Kode KLU</td>
								<td><?= $klien['kode_klu'] ?></td>
							</tr>
							<tr>
								<td>Bentuk Usaha</td>
								<td><?= $klien['bentuk_usaha'] ?></td>
							</tr>
							<tr>
								<td>Jenis Usaha</td>
								<td><?= $klien['jenis_usaha'] ?></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td><?= $klien['alamat'] ?></td>
							</tr>
							<tr>
								<td>Nomor Telepon</td>
								<td><?= $klien['telp'] ?></td>
							</tr>
							<tr>
								<td>Nomor HP</td>
								<td><?= $klien['no_hp'] ?></td>
							</tr>
							<tr>
								<td>Nomor Akte Terakhir</td>
								<td><?= $klien['no_akte'] ?></td>
							</tr>
						</div>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card-deck">
				<div class="card card-shadow">
					<div class="card-body">
						<h5 class="card-title">Pimpinan</h5>
						<table class="table table-detail mb-0">
							<div class="table-body">
								<tr>
									<td>Nama Pimpinan</td>
									<td><?= $klien['nama_pimpinan'] ?></td>
								</tr>
								<tr>
									<td>Jabatan</td>
									<td><?= $klien['jabatan'] ?></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><?= $klien['email_pimpinan'] ?></td>
								</tr>
								<tr>
									<td>Nomor HP</td>
									<td><?= $klien['no_hp_pimpinan'] ?></td>
								</tr>
							</div>
						</table>
					</div>
				</div>
				<div class="card card-shadow">
					<div class="card-body">
						<h5 class="card-title">Counterpart</h5>
						<table class="table table-detail mb-0">
							<div class="table-body">
								<tr>
									<td>Nama Counterpart</td>
									<td><?= $klien['nama_counterpart'] ?></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><?= $klien['email_counterpart'] ?></td>
								</tr>
								<tr>
									<td>Nomor HP</td>
									<td><?= $klien['no_hp_counterpart'] ?></td>
								</tr>
							</div>
						</table>
					</div>
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
		
		function verif(tipe,input) {
			$.ajax({
				type	: 'POST',
				data	: {
					type	: tipe,
					input	: input,
					},
				url		: '<?= base_url() ?>klien/profile/verification',
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

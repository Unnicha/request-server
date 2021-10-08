<div class="content container-fluid">
	<!-- Trigger Modal -->
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif;
		if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->userdata('tipe')?>"></div>
	<?php endif ?>
	
	<h3 class="content-header"><?=$judul?></h3>
	
	<!-- Card Akun -->
	<div class="card card-shadow mb-4">
		<div class="card-body p-4">
			<h5 class="card-title">Info Akun</h5>
			<table class="table table-detail table-responsive-sm mt-3">
				<tbody>
					<tr>
						<td class="detail-title">ID Klien</td>
						<td id="id_user"><?= $klien['id_klien'] ?></td>
						<td></td>
					</tr>
					<tr>
						<td class="detail-title">Nama Klien</td>
						<td><?= $klien['nama'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="nama">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
					<tr>
						<td class="detail-title">Email</td>
						<td><?= $klien['email_user'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="email">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
					<tr>
						<td class="detail-title">Username</td>
						<td><?= $klien['username'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="username">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
					<tr>
						<td class="detail-title">Password</td>
						<td><?= $klien['passcode'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="password">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<!-- Card Usaha -->
	<div class="card card-shadow mb-4">
		<div class="card-body p-4">
			<h5 class="card-title">Info Usaha</h5>
			<table class="table table-detail table-responsive-sm mt-3">
				<tbody>
					<tr>
						<td class="detail-title">Nama Usaha</td>
						<td><?= $klien['nama_usaha'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Kode KLU</td>
						<td><?= $klien['kode_klu'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Bentuk Usaha</td>
						<td><?= $klien['bentuk_usaha'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Jenis Usaha</td>
						<td><?= $klien['jenis_usaha'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Alamat</td>
						<td><?= $klien['alamat'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Nomor Telepon</td>
						<td><?= $klien['telp'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Nomor HP</td>
						<td><?= $klien['no_hp'] ?></td>
					</tr>
					<tr>
						<td class="detail-title">Nomor Akte Terakhir</td>
						<td><?= $klien['no_akte'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card-deck">
		<div class="card card-shadow">
			<div class="card-body p-4">
				<h5 class="card-title">Pimpinan</h5>
				<table class="table table-detail table-responsive-md mt-3">
					<tbody>
						<tr>
							<td class="detail-title">Nama Pimpinan</td>
							<td><?= $klien['nama_pimpinan'] ?></td>
						</tr>
						<tr>
							<td class="detail-title">Jabatan</td>
							<td><?= $klien['jabatan'] ?></td>
						</tr>
						<tr>
							<td class="detail-title">Email</td>
							<td><?= $klien['email_pimpinan'] ?></td>
						</tr>
						<tr>
							<td class="detail-title">Nomor HP</td>
							<td><?= $klien['no_hp_pimpinan'] ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card card-shadow">
			<div class="card-body p-4">
				<h5 class="card-title">Counterpart</h5>
				<table class="table table-detail table-responsive-md mt-3">
					<tbody>
						<tr>
							<td class="detail-title">Nama Counterpart</td>
							<td><?= $klien['nama_counterpart'] ?></td>
						</tr>
						<tr>
							<td class="detail-title">Email</td>
							<td><?= $klien['email_counterpart'] ?></td>
						</tr>
						<tr>
							<td class="detail-title">Nomor HP</td>
							<td><?= $klien['no_hp_counterpart'] ?></td>
						</tr>
					</tbody>
				</table>
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
					id		: $('#id_user').html(),
					},
				url		: '<?= base_url() ?>klien/profile/verification',
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

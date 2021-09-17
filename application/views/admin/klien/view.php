<div class="content container-fluid">
	<!-- Trigger Modal -->
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif;
		if($this->session->flashdata('pass')) : ?>
		<div class="passVerif" data-val="yes" data-tipe="<?=$this->session->flashdata('tipe')?>"></div>
	<?php endif; ?>
	
	<div class="row mb-3">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
		<div class="col-auto">
			<a href="<?=base_url()?>admin/master/klien" class="btn btn-secondary">Kembali</a>
		</div>
	</div>
	
	<div class="card card-shadow mb-4">
		<div class="card-body p-4">
			<!-- Sub-title -->
			<h5 class="card-title">Info Akun</h5>
			
			<table class="table table-detail">
				<tbody>
					<tr>
						<td>ID Klien</td>
						<td class="id_user"><?= $user['id_user'] ?></td>
						<td></td>
					</tr>
					<tr>
						<td>Nama Klien</td>
						<td><?= $user['nama'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="nama" data-input="user">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?= $user['email_user'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="email" data-input="user">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
					<tr>
						<td>Username</td>
						<td><?= $user['username'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="username" data-input="user">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td><?= $user['passcode'] ?></td>
						<td>
							<a type="button" class="verif float-right" data-tipe="password" data-input="user">
								<i class="bi bi-pencil-square"></i>
								ganti
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card card-shadow mb-4">
		<div class="card-body p-4">
			<div class="row">
				<div class="col"><h5 class="card-title">Info Usaha</h5></div>
				<div class="col-auto">
					<a class="btn btn-sm btn-primary verif float-right" data-tipe="usaha" data-input="profil">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			
			<table class="table table-detail">
				<tbody>
					<tr>
						<td>Nama Usaha</td>
						<td><?= $user['nama_usaha']; ?></td>
					</tr>
					<tr>
						<td>Kode KLU</td>
						<td><?= $user['kode_klu']; ?></td>
					</tr>
					<tr>
						<td>Nama Usaha</td>
						<td><?= $user['nama_usaha']; ?></td>
					</tr>
					<tr>
						<td>Bentuk Usaha</td>
						<td><?= $user['bentuk_usaha']; ?></td>
					</tr>
					<tr>
						<td>Jenis Usaha</td>
						<td><?= $user['jenis_usaha']; ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td><?= $user['alamat']; ?></td>
					</tr>
					<tr>
						<td>Nomor Telepon</td>
						<td><?= $user['telp']; ?></td>
					</tr>
					<tr>
						<td>Nomor HP</td>
						<td><?= $user['no_hp']; ?></td>
					</tr>
					<tr>
						<td>Nomor Akte Terakhir</td>
						<td><?= $user['no_akte']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card card-shadow mb-4">
		<div class="card-body p-4">
			<div class="row">
				<div class="col">
					<h5 class="card-title">Pimpinan</h5>
				</div>
				<div class="col-auto">
					<a class="btn btn-sm btn-primary verif float-right" data-tipe="pimpinan" data-input="profil">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			
			<table class="table table-detail">
				<tbody>
					<tr>
						<td>Nama</td>
						<td><?= $user['nama_pimpinan']; ?></td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td><?= $user['jabatan']; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?= $user['email_pimpinan']; ?></td>
					</tr>
					<tr>
						<td>Nomor HP</td>
						<td><?= $user['no_hp_pimpinan']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	
	
	<div class="card card-shadow">
		<div class="card-body p-4">
			<div class="row">
				<div class="col">
					<h5 class="card-title">Counterpart</h5>
				</div>
				
				<div class="col-auto">
					<a class="btn btn-sm btn-primary verif float-right" data-tipe="counterpart" data-input="profil">
						<i class="bi bi-pencil-square"></i>
						ganti
					</a>
				</div>
			</div>
			
			<table class="table table-detail">
				<tbody>
					<tr>
						<td>Nama</td>
						<td><?= $user['nama_counterpart']; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?= $user['email_counterpart']; ?></td>
					</tr>
					<tr>
						<td>Nomor HP</td>
						<td><?= $user['no_hp_counterpart']; ?></td>
					</tr>
				</tbody>
			</table>
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

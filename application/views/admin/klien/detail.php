<div class="modal-header">
	<h5 class="modal-title" id="detailProfilLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-4">
	<div class="container-fluid p-0">
		<table class="table table-striped table-bordered table-detail mb-0">
			<tbody>
				<tr>
					<td colspan="2"><b>DETAIL AKUN</b></td>
				</tr>
				<tr>
					<td scope="row">ID Klien</td>
					<td><?= $klien['id_klien']; ?></td>
				</tr>
				<tr>
					<td scope="row">Nama Klien</td>
					<td><?= $klien['nama_klien']; ?></td>
				</tr>
				<tr>
					<td scope="row">Username</td>
					<td><?= $klien['username']; ?></td>
				</tr>
				<tr>
					<td scope="row">Email</td>
					<td><?= $klien['email']; ?></td>
				</tr>
				
				<tr>
					<td colspan="2"><b>DETAIL USAHA</b></td>
				</tr>
				<tr>
					<td scope="row">Kode KLU</td>
					<td><?= $klien['kode_klu']; ?></td>
				</tr>
				<tr>
					<td scope="row">Bentuk Usaha</td>
					<td><?= $klien['bentuk_usaha']; ?></td>
				</tr>
				<tr>
					<td scope="row">Jenis Usaha</td>
					<td><?= $klien['jenis_usaha']; ?></td>
				</tr>
				<tr>
					<td scope="row">Alamat</td>
					<td><?= $klien['alamat']; ?></td>
				</tr>
				<tr>
					<td scope="row">Nomor Akte Terakhir</td>
					<td><?= $klien['no_akte']; ?></td>
				</tr>
				<tr>
					<td scope="row">Nomor Telepon</td>
					<td><?= $klien['telp']; ?></td>
				</tr>
				<tr>
					<td scope="row">Nomor HP</td>
					<td><?= $klien['no_hp']; ?></td>
				</tr>
				<tr>
					<td scope="row">Status Pekerjaan</td>
					<td><?= $klien['status_pekerjaan']; ?></td>
				</tr>
				
				<tr>
					<td colspan="2"><b>PIMPINAN</b></td>
				</tr>
				<tr>
					<td scope="row">Nama Pimpinan</td>
					<td><?= $klien['nama_pimpinan']; ?></td>
				</tr>
				<tr>
					<td scope="row">Jabatan</td>
					<td><?= $klien['jabatan']; ?></td>
				</tr>
				<tr>
					<td scope="row">Nomor HP Pimpinan</td>
					<td><?= $klien['no_hp_pimpinan']; ?></td>
				</tr>
				<tr>
					<td scope="row">Email Pimpinan</td>
					<td><?= $klien['email_pimpinan']; ?></td>
				</tr>
				
				<tr>
					<td colspan="2"><b>COUNTERPART</b></td>
				</tr>
				<tr>
					<td scope="row">Nama Counterpart</td>
					<td><?= $klien['nama_counterpart']; ?></td>
				</tr>
				<tr>
					<td scope="row">Nomor HP Counterpart</td>
					<td><?= $klien['no_hp_counterpart']; ?></td>
				</tr>
				<tr>
					<td scope="row">Email Counterpart</td>
					<td><?= $klien['email_counterpart']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


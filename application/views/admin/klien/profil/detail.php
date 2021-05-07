<div class="modal-header">
	<h5 class="modal-title" id="detailProfilLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
    <table class="table table-striped table-detail mb-0">
        <tbody>
            <tr>
                <td  style="width:250px" scope="row">ID Klien</td>
                <td><?= $klien['id_klien']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Nama Klien</td>
                <td><?= $klien['nama_klien']; ?></td>
            </tr>

            <tr>
                <td  style="width:250px" scope="row">Status Pekerjaan</td>
                <td><?= $klien['status_pekerjaan']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Kode KLU</td>
                <td><?= $klien['kode_klu']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Bentuk Usaha</td>
                <td><?= $klien['bentuk_usaha']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Jenis Usaha</td>
                <td><?= $klien['jenis_usaha']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Alamat</td>
                <td><?= $klien['alamat']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Nomor Akte Terakhir</td>
                <td><?= $klien['no_akte']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Nomor Telepon</td>
                <td><?= $klien['telp']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Nomor HP</td>
                <td><?= $klien['no_hp']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Email</td>
                <td><?= $klien['email']; ?></td>
            </tr>

            <tr>
                <td  style="width:250px" scope="row">Nama Pimpinan</td>
                <td><?= $klien['nama_pimpinan']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Jabatan</td>
                <td><?= $klien['jabatan']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Nomor HP Pimpinan</td>
                <td><?= $klien['no_hp_pimpinan']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Email Pimpinan</td>
                <td><?= $klien['email_pimpinan']; ?></td>
            </tr>

            <tr>
                <td  style="width:250px" scope="row">Nama Counterpart</td>
                <td><?= $klien['nama_counterpart']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Nomor HP Counterpart</td>
                <td><?= $klien['no_hp_counterpart']; ?></td>
            </tr>
            <tr>
                <td  style="width:250px" scope="row">Email Counterpart</td>
                <td><?= $klien['email_counterpart']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal-footer float-right">
    <a type="button" class="btn btn-info mr-1" href="<?= base_url(); ?>admin/klien/ubah_profil/<?= $klien['id_klien']; ?>">
        Ubah
    </a>
    <a type="button" class="btn btn-danger" href="<?= base_url(); ?>admin/klien/hapus/<?= $klien['id_klien']; ?>" onclick="return confirm('Yakin ingin menghapus data klien <?= $klien['nama_klien'] ?> ?');">
        Hapus
    </a>
</div>

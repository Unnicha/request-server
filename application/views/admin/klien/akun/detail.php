<div class="modal-header">
	<h5 class="modal-title" id="detailAkunLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
    <table class="table table-striped table-detail">
        <tbody>
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
        </tbody>
    </table>

    <a href="<?= base_url(); ?>admin/klien/ubah_akun/<?= $klien['id_klien']; ?>" type="button" class="btn btn-info float-right">
        Ubah
    </a>
</div>

<!--
<div class="modal-footer float-right mr-3">
        <a href="<?= base_url(); ?>klien/hapus/<?= $klien['id_klien']; ?>" type="button" class="btn btn-secondary">Hapus</a>
    </div>
-->

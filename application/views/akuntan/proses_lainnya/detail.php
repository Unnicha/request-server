<div class="modal-header">
	<h5 class="modal-title"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-3">
    <table class="table table-striped table-detail mb-3" id="data">
        <tbody>
            <tr>
                <td scope="row">ID Proses</td>
                <td><?= $proses['id_pengiriman'] ?></td>
            </tr>
            <tr>
                <td scope="row">Klien</td>
                <td><?= $proses['nama_klien'] ?></td>
            </tr>
            <tr>
                <td scope="row">Jenis Data</td>
                <td><?= $proses['jenis_data'] ?></td>
            </tr>
            <tr>
                <td scope="row">Nama Tugas</td>
                <td><?= $proses['nama_tugas'] ?></td>
            </tr>
            <tr>
                <td scope="row">Masa</td>
                <td><?= $proses['masa'] ?></td>
            </tr>
            <tr>
                <td scope="row">Tahun</td>
                <td><?= $proses['tahun'] ?></td>
            </tr>
            <tr>
                <td scope="row">Permintaan ke</td>
                <td><?= $proses['request'] ?></td>
            </tr>
            <tr>
                <td scope="row">Pengiriman ke</td>
                <td><?= ($proses['pembetulan'] + 1) ?></td>
            </tr>
            <tr>
                <td scope="row">Mulai Proses</td>
                <td><?= $proses['tanggal_mulai'] ?> <?= $proses['jam_mulai'] ?></td>
            </tr>
            <tr>
                <td scope="row">Selesai Proses</td>
                <td><?= $proses['tanggal_selesai'] ?> <?= $proses['jam_selesai'] ?></td>
            </tr>
            <tr>
                <td scope="row">Durasi</td>
                <td><?= $durasi ?></td>
            </tr>
            <tr>
                <td scope="row">Standar durasi</td>
                <td><?= $proses['lama_pengerjaan'] ?></td>
            </tr>
            <tr>
                <td scope="row">Keterangan</td>
                <td><?= $proses['keterangan3'] ?></td>
            </tr>
        </tbody>
	</table>
</div>
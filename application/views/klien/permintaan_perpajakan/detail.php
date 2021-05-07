<div class="modal-header">
	<h5 class="modal-title" id="detailLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
    <table class="table table-striped table-detail" id="data">
        <tbody>
            <tr>
                <td scope="row">ID Permintaan</td>
                <td><?= $permintaan['id_permintaan']; ?></td>
            </tr>
            <tr>
                <td scope="row">Nama Klien</td>
                <td><?= $permintaan['nama_klien']; ?></td>
            </tr>
            <tr>
                <td scope="row">Jenis Data</td>
                <td><?= $permintaan['jenis_data']; ?></td>
            </tr>
            <tr>
                <td scope="row">Masa</td>
                <td><?= $permintaan['masa']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tahun</td>
                <td><?= $permintaan['tahun']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tanggal Permintaan</td>
                <td><?= $permintaan['tanggal_permintaan']; ?></td>
            </tr>
            <tr>
                <td scope="row">Keterangan</td>
                <td><?= $permintaan['keterangan']; ?></td>
            </tr>
        </tbody>
	</table>
</div>
<div class="modal-header">
	<h5 class="modal-title" id="detailAkunLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
    <table class="table table-striped table-sm mb-1" id="data">
        <tbody>
            <tr>
                <td scope="row">ID Proses</td>
                <td><?= $proses['id_pengiriman']; ?></td>
            </tr>
            <tr>
                <td scope="row">Jenis Data</td>
                <td><?= $proses['jenis_data']; ?></td>
            </tr>
            <tr>
                <td scope="row">Masa</td>
                <td><?= $proses['masa']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tahun</td>
                <td><?= $proses['tahun']; ?></td>
            </tr>
            <tr>
                <td scope="row">Klien</td>
                <td><?= $proses['nama_klien']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tanggal Mulai</td>
                <td><?= $proses['tanggal_mulai']; ?></td>
            </tr>
            <tr>
                <td scope="row">Jam Mulai</td>
                <td><?= $proses['jam_mulai']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tanggal Selesai</td>
                <td><?= $proses['tanggal_selesai']; ?></td>
            </tr>
            <tr>
                <td scope="row">Jam Selesai</td>
                <td><?= $proses['jam_selesai']; ?></td>
            </tr>
            <tr>
                <td scope="row">Keterangan</td>
                <td><?= $proses['keterangan']; ?></td>
            </tr>
        </tbody>
	</table>
</div>

<div class="modal-footer">
    <a href="<?=base_url()?>akuntan/proses_data_akuntansi/ubah/<?=$proses['id_proses']?>" class="btn btn-info">
        Ubah
    </a>
    <a href="<?=base_url()?>akuntan/proses_data_akuntansi/hapus/<?=$proses['id_proses']?>" class="btn btn-danger" onclick="return_confirm('Yakin ingin menghapus proses <?=$proses['jenis_data'], $proses['nama_klien']?> ?')">
        Hapus
    </a>
</div>
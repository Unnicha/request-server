<div class="modal-header">
	<h5 class="modal-title" id="detailAkunLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body p-4">
    <table class="table table-striped table-detail mb-0" id="data">
        <tbody>
            <tr>
                <td scope="row">ID Pengiriman</td>
                <td><?= $pengiriman['id_pengiriman']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tanggal Permintaan</td>
                <td><?= $pengiriman['tanggal_permintaan']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tanggal Pengiriman</td>
                <td><?= $pengiriman['tanggal_pengiriman']; ?></td>
            </tr>
            <tr>
                <td scope="row">Jenis Data</td>
                <td><?= $pengiriman['jenis_data']; ?></td>
            </tr>
            <tr>
                <td scope="row">Masa</td>
                <td><?= $pengiriman['masa']; ?></td>
            </tr>
            <tr>
                <td scope="row">Tahun</td>
                <td><?= $pengiriman['tahun']; ?></td>
            </tr>
            <tr>
                <td scope="row">Format Data</td>
                <td><?= $pengiriman['format_data']; ?></td>
            </tr>
                <?php if($pengiriman['format_data'] == "Softcopy") { ?>
                <tr>
                    <td scope="row">File</td>
                    <td>
                        <a href="<?=base_url();?><?= $lokasi; ?>/<?= $pengiriman['file']; ?>">
                            <?=$pengiriman['file'] ?>
                        </a>
                    </td>
                </tr>
                <?php } if($pengiriman['format_data'] == "Hardcopy") { ?>
                <tr>
                    <td scope="row">Tanggal Diambil</td>
                    <td><?= $pengiriman['tanggal_ambil']; ?></td>
                </tr>
                <?php } ?>
            <tr>
                <td scope="row">Keterangan</td>
                <td><?= $pengiriman['keterangan2']; ?></td>
            </tr>
        </tbody>
	</table>
</div>
<div class="modal-header pl-4">
	<h5 class="modal-title" id="konfirmLabel"><?= $judul ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body py-4 px-4">
	<div class="row mb-4">
		<div class="col">
			<font size="4"><?=$text?></font>
		</div>
	</div>
	<div class="row float-right">
		<div class="col">
			<?=$button?>
			<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" tabindex="1">Batal</button>
		</div>
	</div>
</div>

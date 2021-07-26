<div class="modal-body p-4">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col">
				<h4 class="text-center"><?= $judul ?></h4>
				<p class="card-subtitle text-muted text-center mb-4"><?= $subjudul ?></p>
			</div>
		</div>
		
		<form action="<?=base_url()?>admin/master/otoritas/verification" method="post">
			<input type="hidden" id="type" name="type" value="<?=$tipe?>">
			<input type="hidden" id="id_user" name="id_user" value="<?=$id_user?>">
			
			<div class="form-group row">
				<input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required>
				<small class="form-text text-danger salah"></small>
				<?php if($this->session->flashdata('pass')) : ?>
					<small class="form-text text-danger"><?= $this->session->flashdata('pass'); ?></small>
				<?php endif; ?>
			</div>
			
			<div class="row float-right">
				<div class="col">
					<button type="submit" name="simpan" class="btn btn-primary">Lanjutkan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</form>
	</div>
</div>

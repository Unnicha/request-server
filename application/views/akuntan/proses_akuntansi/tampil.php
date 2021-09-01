<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<div class="row mb-2">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<?php $status = @$_GET['p']; ?>
	<div class="card card-shadow">
		<div class="card-header">
			<nav class="nav border-bottom" id="myTabs">
				<a class="nav-link active" data-tab="all" style="color:black">
					Semua
				</a>
				<a class="nav-link" data-tab="todo" style="color:black">
					To Do
				</a>
				<a class="nav-link" data-tab="onproses" style="color:black">
					On Proses
				</a>
				<a class="nav-link" data-tab="done" style="color:black">
					Done
				</a>
			</nav>
		</div>
		
		<div class="card-body pt-2 pb-0">
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active"></div>
			</div>
		</div>
	</div>
</div>


<!-- Detail Proses -->
<div class="modal fade detailProses" tabindex="-1" aria-labelledby="detailProsesLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content showProses">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		function view(tab) {
			$.ajax({
				type	: 'POST',
				data	: 'tab='+tab,
				url		: '<?= base_url(); ?>akuntan/proses_data_akuntansi/prosesOn',
				success	: function(data) {
					$('.tab-pane').html(data);
				}
			})
		}
		view('all');
		
		$('#myTabs a').on('click', function() {
			$('a').removeClass('active');
			view( $(this).data('tab') );
			$(this).addClass('active');
		})
	});
</script>

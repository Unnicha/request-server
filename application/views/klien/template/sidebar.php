<nav id="sidebarMenu" class="col-md-3 col-lg-2 pt-2 pt-md-5 d-md-block bg-light sidebar collapse">
	<div class="sidebar-sticky pt-md-1">
		<div class="">
			<!-- Menu Permintaan Data -->
			<ul class="nav flex-column">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Permintaan Data</span>
					<span class="badge badge-light float-right mt-1" id="notif"><?= $this->session->userdata('notif_permintaan'); ?></span>
				</h6>

				<div class="mt-1 mb-2">
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>klien/permintaan_data_akuntansi">
						<i class="bi bi-file-earmark-text sidebar-icon mr-1"></i>
						Data Akuntansi
						<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_permintaan_1'); ?></span>
					</a>
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>klien/permintaan_data_perpajakan">
						<i class="bi bi-file-earmark-text sidebar-icon mr-1"></i>
						Data Perpajakan
						<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_permintaan_2'); ?></span>
					</a>
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>klien/permintaan_data_lainnya">
						<i class="bi bi-file-earmark-text sidebar-icon mr-1"></i>
						Data Lainnya
						<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_permintaan_3'); ?></span>
					</a>
				</div>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Pengiriman Data</span>
					<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_pengiriman'); ?></span>
				</h6>
				
				<div class="mt-1 mb-2">
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>klien/pengiriman_data_akuntansi">
						<i class="bi bi-file-earmark-arrow-up sidebar-icon mr-1"></i>
						Data Akuntansi
						<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_pengiriman_1'); ?></span>
					</a>
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>klien/pengiriman_data_perpajakan">
						<i class="bi bi-file-earmark-arrow-up sidebar-icon mr-1"></i>
						Data Perpajakan
						<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_pengiriman_2'); ?></span>
					</a>
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>klien/pengiriman_data_lainnya">
						<i class="bi bi-file-earmark-arrow-up sidebar-icon mr-1"></i>
						Data Lainnya
						<span class="badge badge-primary float-right mt-1" id="notif"><?= $this->session->userdata('notif_pengiriman_3'); ?></span>
					</a>
				</div>
			</ul>

			<!-- Logout -->
			<div class="row row-child mt-3 mb-5">
				<div class="col text-center">
					<a href="#" class="btn btn-logout" data-toggle="modal" data-target="#logout">
						Keluar
						<i class="bi bi-box-arrow-right sidebar-icon ml-1"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</nav>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 pt-2 pt-md-5 d-md-block bg-light sidebar collapse">
	<div class="sidebar-sticky pt-md-1">
		<div class="">
			<!-- Menu Permintaan Data -->
			<ul class="nav flex-column">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span><?= $this->session->userdata('nama') ?></span>
				</h6>
				<div class="">
					<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/profile">
						<i class="bi bi-person-fill sidebar-icon mr-1"></i>
						Profile
					</a>
				</div>
			</ul>
			
			<!-- Menu Permintaan Data -->
			<ul class="nav flex-column">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Permintaan Data</span>
				</h6>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/permintaan_data_akuntansi">
					<i class="bi bi-sidebar bi-journal-arrow-up sidebar-icon mr-1"></i>
					Data Akuntansi
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/permintaan_data_perpajakan">
					<i class="bi bi-sidebar bi-journal-arrow-up sidebar-icon mr-1"></i>
					Data Perpajakan
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/permintaan_data_lainnya">
					<i class="bi bi-sidebar bi-journal-arrow-up sidebar-icon mr-1"></i>
					Data Lainnya
				</a>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Penerimaan Data</span>
				</h6>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/penerimaan_data_akuntansi">
					<i class="bi bi-sidebar bi-journal-arrow-down sidebar-icon mr-1"></i>
					Data Akuntansi
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/penerimaan_data_perpajakan">
					<i class="bi bi-sidebar bi-journal-arrow-down sidebar-icon mr-1"></i>
					Data Perpajakan
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/penerimaan_data_lainnya">
					<i class="bi bi-sidebar bi-journal-arrow-down sidebar-icon mr-1"></i>
					Data Lainnya
				</a>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Proses Data</span>
				</h6>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/proses_data_akuntansi">
					<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
					Data Akuntansi
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/proses_data_perpajakan">
					<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
					Data Perpajakan
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>akuntan/proses_data_lainnya">
					<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
					Data Lainnya
				</a>
			</ul>
			
			<!-- Logout -->
			<div class="row text-center my-3">
				<div class="col">
					<a href="#" class="btn btn-logout" data-toggle="modal" data-target="#logout">
						Keluar
						<i class="bi bi-box-arrow-right sidebar-icon ml-1"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</nav>
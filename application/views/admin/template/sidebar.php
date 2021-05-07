<nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-sm-1 mt-md-0 pt-sm-2 pt-md-5 d-md-block bg-light sidebar collapse">
	<div class="sidebar-sticky pt-md-1 pt-sm-1 pb-5">
		<div class="accordion" id="accordion">

			<!-- Menu Master -->
			<ul class="nav flex-column mt-0">
				<a class="btn btn-block text-left collapsed" data-toggle="collapse" data-target="#menu1" aria-expanded="false" aria-controls="menu1">
					<h6 id="headingOne" class="sidebar-heading px-2 py-1 d-flex justify-content-between my-0">
						<span>Master</span>
					</h6>
				</a>
				<div class="collapse accordion-submenu px-2 py-1" id="menu1" aria-labelledby="headingOne" data-parent="#accordion">
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/otoritas">
						<i class="bi bi-sidebar bi-person sidebar-icon mr-1"></i>
						Data Admin
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/akuntan">
						<i class="bi bi-sidebar bi-people sidebar-icon mr-1"></i>
						Data Akuntan
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/klien">
						<i class="bi bi-sidebar bi-briefcase sidebar-icon mr-1"></i>
						Data Klien
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/akses">
						<i class="bi bi-sidebar bi-card-list sidebar-icon mr-1"></i>
						Data Akses Klien
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/klu">
						<i class="bi bi-sidebar bi-diagram-3 sidebar-icon mr-1"></i>
						Data KLU
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/jenis_data">
						<i class="bi bi-sidebar bi-files sidebar-icon mr-1"></i>
						Jenis Data
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/tugas">
						<i class="bi bi-sidebar bi-journal-text sidebar-icon mr-1"></i>
						Data Tugas
					</a>
				</div>
			</ul>

			<!-- Menu Permintaan Data -->
			<ul class="nav flex-column mt-0">
				<a class="btn btn-block text-left collapsed" data-toggle="collapse" data-target="#menu2" aria-expanded="false" aria-controls="menu2">
					<h6 id="headingTwo" class="sidebar-heading px-2 py-1 d-flex justify-content-between my-0">
						<span>Permintaan Data</span>
					</h6>
				</a>
				<div class="collapse accordion-submenu px-2 py-1" id="menu2" aria-labelledby="headingTwo" data-parent="#accordion">
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/permintaan_data_akuntansi">
						<i class="bi bi-sidebar bi-journal-arrow-up sidebar-icon mr-1"></i>
						Data Akuntansi
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/permintaan_data_perpajakan">
						<i class="bi bi-sidebar bi-journal-arrow-up sidebar-icon mr-1"></i>
						Data Perpajakan
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/permintaan_data_lainnya">
						<i class="bi bi-sidebar bi-journal-arrow-up sidebar-icon mr-1"></i>
						Data Lainnya
					</a>
				</div>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column mt-0">
				<a class="btn btn-block text-left collapsed" data-toggle="collapse" data-target="#menu3" aria-expanded="false" aria-controls="menu3">
					<h6 id="headingThree" class="sidebar-heading px-2 py-1 d-flex justify-content-between my-0">
						<span>Penerimaan Data</span>
					</h6>
				</a>
				<div class="collapse accordion-submenu px-2 py-1" id="menu3" aria-labelledby="headingThree" data-parent="#accordion">
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/penerimaan_data_akuntansi">
						<i class="bi bi-sidebar bi-journal-arrow-down sidebar-icon mr-1"></i>
						Data Akuntansi
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/penerimaan_data_perpajakan">
						<i class="bi bi-sidebar bi-journal-arrow-down sidebar-icon mr-1"></i>
						Data Perpajakan
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/penerimaan_data_lainnya">
						<i class="bi bi-sidebar bi-journal-arrow-down sidebar-icon mr-1"></i>
						Data Lainnya
					</a>
				</div>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column mt-0">
				<a class="btn btn-block text-left collapsed" data-toggle="collapse" data-target="#menu4" aria-expanded="false" aria-controls="menu4">
					<h6 id="headingFour" class="sidebar-heading px-2 py-1 d-flex justify-content-between my-0">
						<span>Proses Data</span>
					</h6>
				</a>
				<div class="collapse accordion-submenu px-2 py-1" id="menu4" aria-labelledby="headingFour" data-parent="#accordion">
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/proses_data_akuntansi">
						<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
						Data Akuntansi
					</a>
					<!--
					<div class="row" style="background-color:#e2e3e5">
						<div class="col">
							<a class="nav-item sidebar-subheading nav-link pl-5" href="<?= base_url(); ?>admin/proses_data_akuntansi/belum_diproses">
								Belum Diproses
							</a>
							<a class="nav-item sidebar-subheading nav-link pl-5" href="<?= base_url(); ?>admin/proses_data_akuntansi/belum_diproses">
								Sedang Diproses
							</a>
							<a class="nav-item sidebar-subheading nav-link pl-5" href="<?= base_url(); ?>admin/proses_data_akuntansi/belum_diproses">
								Selesai Diproses
							</a>
						</div>
					</div>
					-->
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/proses_data_perpajakan">
						<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
						Data Perpajakan
					</a>
					<a class="nav-item sidebar-subheading nav-link" href="<?= base_url(); ?>admin/proses_data_lainnya">
						<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
						Data Lainnya
					</a>
				</div>
			</ul>

			<!-- Logout -->
			<ul class="nav flex-column">
				<a href="#" class="btn btn-block nav-item sidebar-heading nav-link text-left px-4 py-2" data-toggle="modal" data-target="#logout">
					<i class="bi bi-box-arrow-right sidebar-icon mr-1"></i>
					Logout
				</a>
			</ul>
			<!--
			-->
		</div>
	</div>
</nav>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 pt-sm-2 pt-md-5 d-md-block bg-light sidebar collapse">
	<div class="sidebar-sticky pt-md-1 pt-sm-1">
		<div class="">
			
			<!-- Menu Master -->
			<ul class="nav flex-column mt-0">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Master</span>
				</h6>

				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/otoritas">
					<i class="bi bi-sidebar bi-person sidebar-icon mr-1"></i>
					Data Admin
				</a>
				<div class="accordion" id="accordion">
					<!-- Button Trigger -->
					<a id="heading" class="sidebar-subheading nav-link text-left collapsed" style="cursor: pointer" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="menu">
						<i class="bi bi-sidebar bi-people sidebar-icon mr-1"></i>
						Data Akuntan
						<i class="bi bi-caret-down-fill float-right mt-1"></i>
					</a>
					<!-- Menu Accordion -->
					<div class="collapse accordion-submenu pl-4" id="menu" aria-labelledby="heading" data-parent="#accordion" style="background-color: #dcdcdc">
						<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/akuntan">Otoritas</a>
						<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/akses">Akses Klien</a>
					</div>
				</div>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/klien">
					<i class="bi bi-sidebar bi-briefcase sidebar-icon mr-1"></i>
					Data Klien
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/klu">
					<i class="bi bi-sidebar bi-diagram-3 sidebar-icon mr-1"></i>
					Data KLU
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/jenis_data">
					<i class="bi bi-sidebar bi-files sidebar-icon mr-1"></i>
					Jenis Data
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/tugas">
					<i class="bi bi-sidebar bi-journal-text sidebar-icon mr-1"></i>
					Data Tugas
				</a>
			</ul>
			
			<!-- Menu Permintaan Data -->
			<ul class="nav flex-column mt-0">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Permintaan Data</span>
				</h6>

				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/permintaan_data_akuntansi">
					<i class="bi bi-sidebar bi-file-earmark-text sidebar-icon mr-1"></i>
					Data Akuntansi
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/permintaan_data_perpajakan">
					<i class="bi bi-sidebar bi-file-earmark-text sidebar-icon mr-1"></i>
					Data Perpajakan
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/permintaan_data_lainnya">
					<i class="bi bi-sidebar bi-file-earmark-text sidebar-icon mr-1"></i>
					Data Lainnya
				</a>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column mt-2">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Data Diterima</span>
				</h6>
				
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/penerimaan_data_akuntansi">
					<i class="bi bi-sidebar bi-box-arrow-in-down sidebar-icon mr-1"></i>
					Data Akuntansi
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/penerimaan_data_perpajakan">
					<i class="bi bi-sidebar bi-box-arrow-in-down sidebar-icon mr-1"></i>
					Data Perpajakan
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/penerimaan_data_lainnya">
					<i class="bi bi-sidebar bi-box-arrow-in-down sidebar-icon mr-1"></i>
					Data Lainnya
				</a>
			</ul>
				
			<!-- Menu Pengiriman Data -->
			<ul class="nav flex-column mt-2">
				<h6 class="sidebar-heading btn-block px-3 d-flex justify-content-between align-items-center my-0">
					<span>Proses Data</span>
				</h6>
				
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/proses_data_akuntansi">
					<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
					Data Akuntansi
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/proses_data_perpajakan">
					<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
					Data Perpajakan
				</a>
				<a class="nav-item sidebar-subheading nav-link px-3" href="<?= base_url(); ?>admin/proses_data_lainnya">
					<i class="bi bi-sidebar bi-clipboard-data sidebar-icon mr-1"></i>
					Data Lainnya
				</a>
			</ul>

			<!-- Logout -->
			<div class="row my-3">
				<div class="col text-md-center">
					<a href="#" class="btn btn-logout" data-toggle="modal" data-target="#logout">
						<i class="bi bi-box-arrow-right sidebar-icon mr-1"></i>
						Logout
					</a>
				</div>
			</div>
			<div class="row my-5"></div>
			<!--
			<ul class="nav btn-block flex-column mt-2 mb-5 pl-2">
				<a href="#" class="nav-link sidebar-heading px-3" data-toggle="modal" data-target="#logout">
					<i class="bi bi-box-arrow-right sidebar-icon mr-1"></i>
					Logout
				</a>
			</ul>
			-->
		</div>
	</div>
</nav>
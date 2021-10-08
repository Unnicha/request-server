<nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-4 mt-md-0 d-md-block p-0 sidebar collapse">
	<div class="dashboard text-center">
		HRW CONSULTING
	</div>
	
	<div class="sidebar-sticky pt-0 pb-5">
		<!-- Beranda -->
		<a href="<?= base_url(); ?>admin/home" class="btn btn-block text-left sidebar-header collapsed">
			<i class="bi bi-house-door sidebar-icon mr-1"></i>
			Beranda
		</a>
		<div class=""></div>
		
		<!-- Menu Master -->
		<a class="btn btn-block text-left sidebar-header collapsed" id="headingOne" data-toggle="collapse" data-target="#menu1" aria-expanded="false" aria-controls="menu1">
			<i class="bi bi-layers sidebar-icon mr-1"></i>
			Master
			<span class="menu-arrow"><i class="bi bi-chevron-right"></i></span>
		</a>
		<div class="menus collapse" id="menu1" aria-labelledby="headingOne" data-menu="master">
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/admin">
				Data Admin
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/akuntan">
				Data Akuntan
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/klien">
				Data Klien
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/akses">
				Data Akses Klien
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/klu">
				Data KLU
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/jenis_data">
				Jenis Data
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/master/tugas">
				Data Tugas
			</a>
		</div>
		
		<!-- Menu Permintaan Data -->
		<a class="btn btn-block text-left sidebar-header collapsed" id="headingTwo" data-toggle="collapse" data-target="#menu2" aria-expanded="false" aria-controls="menu2">
			<i class="bi bi-clock sidebar-icon mr-1"></i>
			Permintaan Data
			<span class="menu-arrow"><i class="bi bi-chevron-right"></i></span>
		</a>
		<div class="menus collapse" id="menu2" aria-labelledby="headingTwo" data-menu="permintaan">
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/permintaan/permintaan_data_akuntansi">
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/permintaan/permintaan_data_perpajakan">
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/permintaan/permintaan_data_lainnya">
				Data Lainnya
			</a>
		</div>
			
		<!-- Menu Pengiriman Data -->
		<a class="btn btn-block text-left sidebar-header collapsed" id="headingThree" data-toggle="collapse" data-target="#menu3" aria-expanded="false" aria-controls="menu3">
			<i class="bi bi-box-arrow-in-down sidebar-icon mr-1"></i>
			Pengiriman Data
			<span class="menu-arrow"><i class="bi bi-chevron-right"></i></span>
		</a>
		<div class="menus collapse" id="menu3" aria-labelledby="headingThree" data-menu="pengiriman">
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/pengiriman/pengiriman_data_akuntansi">
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/pengiriman/pengiriman_data_perpajakan">
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/pengiriman/pengiriman_data_lainnya">
				Data Lainnya
			</a>
		</div>
			
		<!-- Menu Pengiriman Data -->
		<a class="btn btn-block text-left sidebar-header collapsed" id="headingFour" data-toggle="collapse" data-target="#menu4" aria-expanded="false" aria-controls="menu4">
			<i class="bi bi-bar-chart-line sidebar-icon mr-1"></i>
			Proses Data
			<span class="menu-arrow"><i class="bi bi-chevron-right"></i></span>
		</a>
		<div class="menus collapse" id="menu4" aria-labelledby="headingFour" data-menu="proses">
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/proses/proses_data_akuntansi">
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/proses/proses_data_perpajakan">
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading" href="<?= base_url(); ?>admin/proses/proses_data_lainnya">
				Data Lainnya
			</a>
		</div>

		<!-- Logout -->
		<a href="#" class="btn btn-block text-left sidebar-header" data-toggle="modal" data-target="#logout">
			<i class="bi bi-box-arrow-right sidebar-icon mr-1"></i>
			Logout
		</a>
	</div>
</nav>

<script>
	$(document).ready(function() {
		var path1	= window.location.pathname;
		var arr1	= path1.split('/');
		$("#sidebarMenu .sidebar-sticky .menus").each(function() {
			var cek = $(this).data('menu');
			if( arr1[3] == cek ) {
				$(this).addClass('show');
				$(this).prev().attr('aria-expanded', 'true');
			}
		});
		$("#sidebarMenu .menus.show .sidebar-subheading").each(function() {
			var path2	= $(this).attr('href');
			var arr2	= path2.split('/');
			if(arr2[6] == arr1[4]) {
				$(this).addClass('active');
			}
		})
	});
</script>
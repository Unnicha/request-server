<nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-4 mt-md-0 d-md-block p-0 sidebar collapse">
	<div class="dashboard text-center">
		HRW CONSULTING
	</div>
	
	<div class="sidebar-sticky pt-0 pb-5">
		<!-- Beranda -->
		<a href="<?= base_url(); ?>akuntan/home" class="nav-item nav-link sidebar-subheading2 <?=($this->uri->segment(2) == 'home') ? 'active' : ''?>">
			<i class="bi bi-house-door mr-1"></i>
			Beranda
		</a>
		<div class=""></div>
		
		<!-- Menu Permintaan -->
		<ul class="nav flex-column">
			<h6 class="sidebar-heading btn-block d-flex align-items-center my-0">
				Permintaan
			</h6>
			<a class="nav-item nav-link sidebar-subheading2 <?=($this->uri->segment(2) == 'permintaan_data_akuntansi') ? 'active' : ''?>" href="<?= base_url(); ?>akuntan/permintaan_data_akuntansi">
				<i class="bi bi-cash-coin mr-1"></i>
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/permintaan_data_perpajakan">
				<i class="bi bi-receipt-cutoff mr-1"></i>
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/permintaan_data_lainnya">
				<i class="bi bi-files mr-1"></i>
				Data Lainnya
			</a>
		</ul>
			
		<!-- Menu Pengiriman -->
		<ul class="nav flex-column">
			<h6 class="sidebar-heading btn-block d-flex align-items-center my-0">
				Pengiriman
			</h6>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/pengiriman_data_akuntansi">
				<i class="bi bi-cash-coin mr-1"></i>
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/pengiriman_data_perpajakan">
				<i class="bi bi-receipt-cutoff mr-1"></i>
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/pengiriman_data_lainnya">
				<i class="bi bi-files mr-1"></i>
				Data Lainnya
			</a>
		</ul>
			
		<!-- Menu Proses -->
		<ul class="nav flex-column">
			<h6 class="sidebar-heading btn-block d-flex align-items-center my-0">
				Proses
			</h6>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/proses_data_akuntansi">
				<i class="bi bi-cash-coin mr-1"></i>
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/proses_data_perpajakan">
				<i class="bi bi-receipt-cutoff mr-1"></i>
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/proses_data_lainnya">
				<i class="bi bi-files mr-1"></i>
				Data Lainnya
			</a>
		</ul>
		
		<!-- Menu Laporan -->
		<ul class="nav flex-column">
			<h6 class="sidebar-heading btn-block d-flex align-items-center my-0">
				Laporan
			</h6>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/export_permintaan">
				<i class="bi bi-journal mr-1"></i>
				Laporan Permintaan
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>akuntan/export_proses">
				<i class="bi bi-bar-chart mr-1"></i>
				Laporan Proses
			</a>
		</ul>
	</div>
</nav>

<script>
	$(document).ready(function() {
		var path1	= window.location.pathname;
		var arr1	= path1.split('/');
		
		$("#sidebarMenu .sidebar-subheading2").each(function() {
			var path2	= $(this).attr('href');
			var arr2	= path2.split('/');
			if(arr2[5] == arr1[3]) {
				$(this).addClass('active');
			}
		})
	});
</script>
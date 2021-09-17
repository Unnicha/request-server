<nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-4 mt-md-0 d-md-block p-0 sidebar collapse">
	<div class="dashboard text-center">
		HRW CONSULTING
	</div>
	
	<div class="sidebar-sticky pt-0 pb-5">
		<!-- Beranda -->
		<a class="nav-item sidebar-subheading2 nav-link" href="<?= base_url(); ?>akuntan/home">
			<i class="bi bi-house-door mr-1"></i>
			Beranda
		</a>
		<div class=""></div>
		
		<!-- Menu Permintaan Data -->
		<ul class="nav flex-column">
			<h6 class="sidebar-heading btn-block d-flex justify-content-between align-items-center my-0">
				Permintaan
			</h6>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>klien/permintaan_data_akuntansi">
				<i class="bi bi-file-earmark-arrow-down mr-1"></i>
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>klien/permintaan_data_perpajakan">
				<i class="bi bi-file-earmark-arrow-down mr-1"></i>
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>klien/permintaan_data_lainnya">
				<i class="bi bi-file-earmark-arrow-down mr-1"></i>
				Data Lainnya
			</a>
		</ul>
		
		<!-- Menu Pengiriman Data -->
		<ul class="nav flex-column">
			<h6 class="sidebar-heading btn-block d-flex justify-content-between align-items-center my-0">
				Pengiriman
			</h6>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>klien/pengiriman_data_akuntansi">
				<i class="bi bi-file-earmark-check mr-1"></i>
				Data Akuntansi
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>klien/pengiriman_data_perpajakan">
				<i class="bi bi-file-earmark-check mr-1"></i>
				Data Perpajakan
			</a>
			<a class="nav-item nav-link sidebar-subheading2" href="<?= base_url(); ?>klien/pengiriman_data_lainnya">
				<i class="bi bi-file-earmark-check mr-1"></i>
				Data Lainnya
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
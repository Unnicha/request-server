<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">

	<!-- Beranda -->
	<a class="navbar-brand nav-profile col-md-3 col-lg-2 mr-0 px-3" href="<?= base_url(); ?>admin/home">
		Beranda
	</a>
	
	<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<span class="nav-item dropdown mr-5">
		<a class="nav-link nav-profile dropdown-toggle" href="#" id="navbarProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
			<?= $this->session->userdata('nama') ?> 
		</a>
		<div class="dropdown-menu dropdown-menu-md-right mx-3" aria-labelledby="navbarProfile">
			<!--
			<a class="dropdown-item" href="<?= base_url(); ?>admin/profile">
				<i class="bi bi-sidebar bi-person-circle mr-2"></i>
				Profil
			</a>
			-->
			<a class="dropdown-item" data-toggle="modal" data-target="#logout">
				<i class="bi bi-sidebar bi-box-arrow-right mr-2"></i>
				Logout
			</a>
		</div>
	</span>
</nav>

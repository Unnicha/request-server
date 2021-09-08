<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-dark sticky-top flex-md-nowrap py-1 px-5 justify-content-end">
	<div class="dropdown nav-item nav-profile d-none d-md-inline">
		<a class="nav-profile" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="bi bi-person-circle mr-1" style="font-size: 24px;"></i>
			<span style="vertical-align: top;">
				<?= $this->session->userdata('nama') ?>
				<i class="bi bi-chevron-down" style="font-size: 10px;"></i>
			</span>
		</a>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<a href="<?= base_url(); ?>admin/profile" class="dropdown-item">Profile</a>
		</div>
	</div>
	
	<button class="navbar-toggler my-2 d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
</nav>

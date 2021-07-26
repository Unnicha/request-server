<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">
	<a class="navbar-brand nav-profile col-3 col-lg-2 mr-0 px-3" href="<?= base_url(); ?>admin/home">
		Beranda
	</a>
	
	<ul class="navbar-nav px-5 d-none d-sm-inline">
		<li class="nav-item text-nowrap">
			<h5 class="mb-0" style="color:white"><?= $this->session->userdata('nama') ?></h5>
		</li>
	</ul>
	
	<button class="navbar-toggler mx-3 d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
</nav>

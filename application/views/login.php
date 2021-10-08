<!doctype html>
<html>
	<head>
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="<?= base_url('asset/css/bootstrap.min.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= base_url('asset/css/bootstrap-me.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= base_url('asset/font/bootstrap-icons.css') ?>">
		
		<title>Selamat Datang | Login</title>
	</head>
	
	<body class="bg-light">
		<div class="container mt-5">
			<div class="row justify-content-md-center pt-3 pt-sm-4">
				<div class="col-lg-5 mb-5 mb-lg-0">
					<h1 class="">Selamat Datang</h1>
					<p class="lead">Di Website Data Konsultan Pajak Hirwan dan Rekan</p>
				</div>
				
				<div class="col-lg-5">
					<div class="card card-round mx-auto">
						<div class="card-body p-5">
							<h2 class="text-center">Login</h2>
							<p class="text-center text-muted mb-4">Silahkan Login disini</p>
							
							<?php if($this->session->flashdata('flash')) : ?>
							<div class="row mt-3">
								<div class="col">
									<small class="form-text text-danger text-center">
										Username dan Password tidak sesuai. 
									</small>
								</div>
							</div>
							<?=$this->session->flashdata('passhash')?>
							<?php endif; ?>
	
							<div class="row justify-content-md-center">
								<div class="col-sm">
									<form action="" method="post">
										<div class="form-group row">
											<div class="col-sm">
												<label for="username">Username</label> 
												<input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username" value="<?=set_value('username')?>" required autofocus>
											</div>
										</div>
										
										<div class="form-group row">
											<div class="col-sm">
												<label for="password">Password</label> 
												<input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
											</div>
										</div>
										
										<small class="form-text">
											<a href="<?=base_url()?>login/forget_password" tabindex="-1">
												Lupa password? 
											</a>
										</small> 
										
										<div class="row mt-3 float-right">
											<div class="col-sm">
												<button type="submit" class="btn btn-primary">Login</button>
												<button type="reset" class="btn btn-secondary">Reset</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="<?= base_url('asset/js/jquery.js') ?>"></script>
		<script src="<?= base_url('asset/js/bootstrap.bundle.min.js') ?>"></script>
	</body>
</html>
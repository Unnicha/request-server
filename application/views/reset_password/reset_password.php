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
		
		<title>Reset Password</title>
	</head>
	
	<body class="bg-light">
		<div class="container mt-5">
			<div class="row justify-content-md-center pt-3 pt-sm-4">
				<div class="col-8">
					<div class="card card-shadow mx-auto">
						<div class="card-body p-5">
							<h3 class="text-center mb-3">Reset Password</h3>
							<p class="text-center mb-1"><i class="bi bi-person-fill mr-1"></i><?=$nama?></p>
							<p class="text-center text-muted mb-3">Silahkan masukkan password baru Anda</p>
							
							<div class="row justify-content-md-center">
								<div class="col-sm">
									<form action="" method="post">
										<div class="form-group row">
											<div class="col-sm">
												<label for="password">Password</label> 
												<input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required autofocus>
											</div>
										</div>
										
										<div class="form-group row">
											<div class="col-sm">
												<label for="passconf">Username</label> 
												<input type="password" name="passconf" class="form-control" id="passconf" placeholder="Masukkan Username" required>
											</div>
										</div>
										
										<div class="row mt-4 float-right">
											<div class="col-sm">
												<button type="submit" class="btn btn-primary">Simpan</button>
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
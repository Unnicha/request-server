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
		<div class="container-fluid container-login">
            <div class="row justify-content-center"> 
                <div class="col-8">
                    <div class="row">
                        <div class="col">
                            <h3>Email konfirmasi terkirim</h3>
                            <p>Klik tautan yang dikirim ke alamat email Anda untuk melakukan reset password.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?=base_url()?>" style="color:black">
                                <i class="bi bi-arrow-right ml-1"></i>
                                <small>Ke halaman login</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <script src="<?= base_url('asset/js/jquery.js') ?>"></script>
        <script src="<?= base_url('asset/js/bootstrap.bundle.min.js') ?>"></script>

    </body>
</html>
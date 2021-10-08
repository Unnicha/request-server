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
            <div class="row justify-content-md-center"> 
                <div class="col-8">
                    <h3 class="mb-4">Reset Password</h3>
    
                    <p class="text-muted">
                        Masukkan email Anda untuk menerima pesan konfirmasi.
                    </p>
                    
                    <form action="" method="post">
                        <div class="form-group row">
                            <div class="col-sm">
                                <label for="email">Email</label> 
                                <input type="email" name="email" class="form-control" id="email" placeholder="" required autofocus>
                            </div>
                        </div>
                        
                        <?php if($this->session->flashdata('flash')) : ?>
                        <div class="row">
                            <div class="col-sm">
                                <small class="text-danger">
                                    Email tidak terkait dengan akun manapun.
                                </small>
                            </div> 
                        </div>
                        <?php endif; ?>
                        
                        <div class="row mt-4">
                            <div class="col-sm">
                                <a href="<?=base_url()?>" style="color:black" tabindex="-1">
                                    <i class="bi bi-arrow-left mr-1"></i>
                                    <small>Kembali ke login</small>
                                </a>
                            </div>
                            <div class="col-sm">
                                <button type="submit" name="kirim" class="btn btn-primary float-right">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="<?= base_url('asset/js/jquery.js') ?>"></script>
        <script src="<?= base_url('asset/js/bootstrap.bundle.min.js') ?>"></script>

    </body>
</html>
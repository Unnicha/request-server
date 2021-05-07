<!doctype html>
<html>
    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('asset/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/javascript" href="<?= base_url('asset/js/jquery.js') ?>">
	
        <title>Selamat Datang</title>
    </head>

    <body>
		<div class="container">
            <div class="row justify-content-md-center mt-5">
                <div class="col-md-6">
                    <h2 class="text-center">Silahkan Login</h2>
                    <form action="" method="post">
                        <div class="form-group row mt-4">
                            <label for="username" class="col-sm-4 col-form-label">Username</label> 
                            <div class="col-sm">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password</label> 
                            <div class="col-sm">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm">
                                <button type="submit" class="btn btn-primary">Login</button>&nbsp;
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>
    <link rel="stylesheet" href="<?=base_url("assets/dist/bootstrap-5.1.3-dist/css/bootstrap.min.css");?>">
</head>

<body>

    <div class="container-fluid bg-light">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12">
                            Warehouse Management System
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-login" name="form-login" action="<?=base_url("dexin/loginValidation")?>" method="post" class="justify-content-center">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required="true">
                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required="true">
                    <span class="text-danger"><?php echo form_error('password'); ?></span> 
                    <?php echo '<h6 class="text-danger mt-3">'.$this->session->flashdata("error").'</h6>'; ?>    
                    <button class="btn btn-primary mt-3" id="btn-login" name="btn-login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url("assets/dist/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js");?>"></script>
</body>

</html>
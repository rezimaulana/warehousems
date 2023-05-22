<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>
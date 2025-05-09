<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{assets("plugins/fontawesome-free/css/all.min.css")}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{assets("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{assets("dist/css/adminlte.min.css")}}">
</head>
<body >

@include(component("navauth"))
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="login-logo">
        </div>
         <div class="col-xl-5 col-lg-5 col-md-6 col-12">
         
          <!-- /.login-logo -->
        <div class="card">
          <div class="card-body login-card-body">
            <h3>Regístrate</h3>
            @include(component("alertas"))
            <form action="{{redirect("user/store")}}" method="post">
              <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
              <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Nombre de usuario...">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
              <div class="input-group mb-3">
                <input type="text" name="email" class="form-control" placeholder="Ingrese su email...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success">Regístrate <i class="fas fa-save"></i></button>
                </div>
                <!-- /.col -->
              </div>
            </form>
       
             
          </div>
          <!-- /.login-card-body -->
        </div>
         </div>
      </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{assets("plugins/jquery/jquery.min.js")}}"></script>
<!-- Bootstrap 4 -->
<script src="{{assets("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{assets("dist/js/adminlte.min.js")}}"></script>
</body>
</html>

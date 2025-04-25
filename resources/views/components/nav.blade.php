<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
 
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
         @php
          $Foto = $this->getUser()[0]->foto != null ? '' : assets("dist/img/useranonimo.png");
          @endphp
        <img src="{{$Foto}}" class="img-circle elevation-2" alt="User Image"
        style="width: 40px;">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header"><b>{{$this->getUser() === 'a' ? 'ADMINISTRADOR' : 'CLIENTE'}}</b></span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Mi Perfíl
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout" onclick="event.preventDefault(); document.getElementById('form_logout').submit()" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Cerrar Sesión
          </a>

          <form action="{{redirect("logout")}}" method="post" id="form_logout">
             <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
          </form>
           
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
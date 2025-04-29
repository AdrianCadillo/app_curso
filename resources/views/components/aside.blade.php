<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{assets("dist/img/AdminLTELogo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @php
              $Foto = $this->getUser()[0]->foto != null ? assets("img/users/".$this->getUser()[0]->foto) : assets("dist/img/useranonimo.png");
          @endphp
          <img src="{{$Foto}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><b>{{$this->getUser()[0]->username}}</b></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
         @if ($this->getUser()[0]->rol === 'a')
         <li class="nav-item">
          <a href="{{redirect("gestion-de-usuarios")}}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <b>
              Gestionar usuarios
            </b>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{redirect("categorias")}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <b>
              categorias
            </b>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{redirect("productos")}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <b>
              Productos
            </b>
          </a>
        </li>
         @endif

          @if ($this->getUser()[0]->rol === 'u')
          <li class="nav-item">
            <a href="{{redirect("productos")}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <b>
                Mis compras
              </b>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
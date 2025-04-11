@if ($this->ExisteSession("success"))
    <div class="alert alert-success">{{$this->getSesion("success")}}</div>
@endif

@if ($this->ExisteSession("error"))
    <div class="alert alert-danger">{{$this->getSesion("error")}}</div>
@endif

@if ($this->ExisteSession("existe"))
    <div class="alert alert-warning">{{$this->getSesion("existe")}}</div>
@endif

@if ($this->ExisteSession("errors"))
    <div class="alert alert-danger">
        <ul>
            @foreach ($this->getSesion("errors") as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

 



{{--- ELIMINAR LAS SESIONES---}}
@php
    $this->DestroySession("success");
    $this->DestroySession("error");
    $this->DestroySession("existe");
    $this->DestroySession("errors");
@endphp
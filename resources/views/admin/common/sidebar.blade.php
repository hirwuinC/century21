<div class="sidebar-nav">
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav" id="sidenav01">
                <li class="headerNav">
                    <div class="contentAvatar">
                        <div>
                            <span></span>
                            <p>Nombre Apellido</p>
                        </div>
                    </div>
                </li>
                <li class="active"><a href="">Inicio</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed">
                        Inmuebles <span class="caret"></span>
                    </a>
                    <div class="collapse" id="toggleDemo" style="height: 0px;">
                        <ul class="nav nav-list">
                            <li><a href="{{ route('admin_lista_inmuebles') }}">lista de inmuebles</a></li>
                            <li><a href="{{ route('crear-inmueble-1') }}">Crear inmuebles</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#toggleDemo2" data-parent="#sidenav01" class="collapsed">
                        proyectos <span class="caret"></span>
                    </a>
                    <div class="collapse" id="toggleDemo2" style="height: 0px;">
                        <ul class="nav nav-list">
                            <li><a href="{{ route('admin_lista_inmuebles') }}">Lista de proyectos</a></li>
                            <li><a href="{{route('crear-inmueble-1')}}">Crear Proyecto</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#"></span>estadisticas</a></li>
                <li><a href="#">clientes</a> </li>
                <li><a href="{{ route('lista-agente') }}">Asesores</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
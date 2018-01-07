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

                @foreach($permisos as $permiso)
                <li>
                  <a href="{{$permiso->url}}" data-toggle="{{$permiso->id_input}}" data-target="{{$permiso->target}}" data-parent="#sidenav01" class="{{$permiso->class_input}}">
                      {{$permiso->nombre}} <span class="caret"></span>
                  </a>
                  <div class="{{$permiso->id_input}}" id="{{$permiso->padre}}" style="height: 0px;">
                        <ul class="nav nav-list">
                          @foreach($submodulos as $submodulo)
                            @if($permiso->id == $submodulo->padre)
                              <li><a href="{{ $submodulo->url }}">{{$submodulo->nombre}}</a></li>
                            @endif
                          @endforeach
                        </ul>
                  </div>
                </li>
                @endforeach

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

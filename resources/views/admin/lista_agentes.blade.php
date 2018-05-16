@extends('admin/base_admin')

@section('content')
<div class="contentAgents">
    <h2 class="titleSection">Lista de Asesores</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <div class="iconInput">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
                <input type="search" class="inputs form-control" id="exampleInputSearch" placeholder="Nombre / Código Asesor">
                <input type="hidden" id="valor">
                <ul class="register-list">
                </ul>
            </div>
        </div>
    </div>
    <div class="agents register-list2">
        <div class="row">
            <div class="col-xs-12 listAgents ">
                @foreach($asesores as $asesor)
                    @component('admin/partials/agente')
                        @slot('imagen')
                          <div class="contentAvatar">
                              <div>
                                  <span><img class="image" src="{{ asset('/images/asesores')}}/{{$asesor->nombreimagen}}"></span>
                              </div>
                          </div>
                        @endslot
                        @slot('fullname')
                            {{$asesor->fullName}}
                        @endslot
                        @slot('asesor_id')
                            {{$asesor->id}}
                        @endslot
                    @endComponent
                @endforeach
            </div>
        </div>
    </div>
</div>
    @component('admin/common/paginador')
      @slot('paginador')
        {{ $asesores->links() }}
      @endslot
    @endComponent
@endSection

@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/search.js') }}"></script>
@endSection

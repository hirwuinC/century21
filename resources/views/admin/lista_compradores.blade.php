@extends('admin/base_admin')

@section('content')
<div class="contentAgents">
    <h2 class="titleSection">Compradores</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <div class="iconInput">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
                <input type="search" class="inputs form-control" id="exampleInputSearch" placeholder="Nombre / Cédula ">
                <input type="hidden" id="valor">
                <ul class="register-list">
                </ul>
            </div>
        </div>
    </div>
    <div class="agents register-list2">
        <div class="row">
            <div class="col-xs-12 listAgents ">
                @foreach($compradores as $comprador)
                    @component('admin/partials/comprador')
                        @slot('fullname')
                            {{ $comprador->fullNameComprador}}
                        @endslot
                        @slot('comprador_id')
                            {{$comprador->id}}
                        @endslot
                    @endComponent
                @endforeach
            </div>
        </div>
    </div>
</div>
    @component('admin/common/paginador')
      @slot('paginador')
        {{ $compradores->links() }}
      @endslot
    @endComponent
@endSection

@section('js')
    <script type="text/javascript" src="{{ asset('js/admin/compradores/buscarComprador.js') }}""></script>
@endSection

@extends('admin/base_admin')

@section('content')
<div class="contentAgents">
    <h2 class="titleSection">Lista de agentes</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <div class="iconInput">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
                <input type="trext" class="inputs form-control" id="exampleInputSearch" placeholder="Buscar agente">
            </div>
        </div>
    </div>
    <div class="agents">
        <div class="row">
            <div class="col-xs-12 listAgents">
                @foreach($asesores as $asesor)
                    @component('admin/partials/agente')
                        @slot('fullname')
                            {{ ucwords(strtolower($asesor->fullName))}}
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
    @endComponent
@endSection


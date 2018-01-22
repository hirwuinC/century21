@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles - <span>Agregar o quitar imágenes</span></h2>
    <section>
        <div class="row nueva">
          @component('admin/partials/uploadImagen2')
          @endComponent
          <div class="col-sm-3">
            <div class="addPicCont">
                <a class="addPic" id="addPic" href="#">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="buttons">
                <div class="col-xs-3 col-xs-offset-6">
                    <button id="redirectButtomAction1" type="button" class="btnGrayHight">ATRAS</button>
                </div>
                <div class="col-xs-3">
                    <button id="redirectButtomAction2" type="button" class="btnYellow">siguiente</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/admin/propiedades/nuevoinmueble.js') }}"></script>
<script>
    var redirectButtomUrl1 = "{{ route('crear-inmueble-1') }}";
    var redirectButtomUrl2 = "{{ route('admin_lista_inmuebles') }}";
    $('#redirectButtomAction1').on('click',function(){
        window.location.href = redirectButtomUrl1;
    })
    $('#redirectButtomAction2').on('click',function(){
        window.location.href = redirectButtomUrl2;
    })
</script>
@endSection

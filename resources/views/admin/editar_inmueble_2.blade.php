@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles - <span>Agregar o quitar imágenes</span></h2>
    <section>
      <form class="" id="picPropiety" action="" enctype= multipart/form-data method="post">
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
                    <button type="submit" id="savePropiety" type="submit" class="btnYellow">siguiente</button>
                </div>
            </div>
        </div>
      </form>
    </section>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/admin/propiedades/editarinmueble.js') }}"></script>
<script>
    var redirectButtomUrl1 = "{{ route('editar-inmueble-1',1) }}";
    $('#redirectButtomAction1').on('click',function(){
        window.location.href = redirectButtomUrl1;
    })
</script>
@endSection

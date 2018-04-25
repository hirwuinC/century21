@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles - <span>Agregar o quitar imágenes</span></h2>
    <section>
      <form class="" id="picPropiety" action="" enctype="multipart/form-data" method="post">
        <input type="hidden" id="last" value="{{$ultimo['id']}}">
        <div class="row nueva">
          @foreach($imagenes as $imagen)
            @component('admin/partials/uploadImagen2')
              @slot('img')
                @if($propiedad->id_mls==0)
                  <img src="{{ asset('images/inmuebles')}}/{{$imagen->nombre}}" alt="">
                @else
                  <img src="{{$imagen->nombre}}" alt="">
                @endif
              @endslot
              @slot('contador')
              {{$imagen->id}}
              @endslot
              @slot('marcador')
                @if($imagen->vista==1)
                  <input type="radio" name="fotovisible" value="{{$imagen->id}}" id="radio-example-{{$imagen->id}}" checked="checked"/>
                  <label for="radio-example-{{$imagen->id}}"></label>
                @else
                  <input type="radio" name="fotovisible" value="{{$imagen->id}}" id="radio-example-{{$imagen->id}}"/>
                  <label for="radio-example-{{$imagen->id}}"></label>
                @endif
              @endslot
            @endComponent
          @endforeach
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
                    <button type="submit" id="savePropiety" type="submit" class="btnYellow">Guardar</button>
                </div>
            </div>
        </div>
      </form>
    </section>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/admin/propiedades/nuevoinmueble.js') }}"></script>
<script>
    var redirectButtomUrl1 = "{{ route('crear-inmueble-1') }}";
    $('#redirectButtomAction1').on('click',function(){
        window.location.href = redirectButtomUrl1;
    })
</script>
@endSection

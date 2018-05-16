@extends('base')

@section('content')

<div class="container">
    <div class="row">
        <!-- GO CONTENT INFO -->
        <div class="col-xs-12 col-sm-8">
            <h1 class="titleSection">Nuestra Historia</h1>
            <section class="ourHistory">
              <div class="col-xs-12 col-sm-12 video">
                  <iframe  src="https://www.youtube.com/embed/u3DEiLfCZrc?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
              </div>
              <h1 class="titleSection" >Nos debemos a nuestros clientes</h1>
              <div class="col-xs-12 col-sm-12 esquema hijo">
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="col-xs-12">
                      <p class="contenido1">Nuestra Misión es ayudar a los clientes a que hagan <strong>excelentes negocios inmobiliarios.</strong></p>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="col-xs-5 contllave">
                    <span class="llave">{</span>
                  </div>
                  <div class="col-xs-7">
                      <p class="contenido">Para lograr esta misión asumimos los retos de brindar a los clientes <strong>un servicio inmobiliario extraordinario.</strong></p>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="col-xs-5 contllave">
                    <span class="llave">{</span>
                  </div>
                  <div class="col-xs-7">
                      <p class="contenido">De esta manera buscamos que los clientes se conviertan en <strong>clientes de por vida.</strong></p>
                  </div>
                </div>
              </div>
              <h1 class="titleSection">Brindar un servicio extraordinario significa</h1>
                <div class="col-xs-12 col-sm-12 video">
                  <p>Brindar a los clientes mucho más valor del que esperan.</p>
                  <p>Esmerarnos para conseguir las mejores oportunidades para los cliente.</p>
                  <p>Capacitarnos constantemente para brindar a los clientes conocimientos oportunos.</p>
                  <p>Apoyarnos en todas las oficinas y asesores que conforman el sistema C21, nacional e internacionalmente.</p>
                <div>
              <h1 class="titleSection">Para brindar un servicio extraordinario</h1>
                <div class="col-xs-12 col-sm-12 video hijo">
                  <p>En Century 21 Inmuebles Caracas nos basamos en estos valores:</p>
                  <p>El profesionalismo de nuestros asesores.</p>
                  <p>La honestidad en todas nuestras acciones.</p>
                  <img src="{{asset('images/confianza.jpg')}}" alt="">
                </div>
              <h1 class="titleSection">Nos avala una trayectoria de constancia</h1>
              <div class="col-xs-12 col-sm-12 video hijo">
                <p>Century 21 Inmuebles Caracas fue fundada en 1999.</p>
                <p>Somos pioneros de la marca Century 21 en Venezuela.</p>
                <p>Siempre hemos estado entre las 10 primeras mejores oficinas de C21 en todo el país.</p>
                <p>Hemos recibido el "Premio Centurión" en muchas oportunidades por la cantidad de negocios inmobiliarios concluidos de manera satisfactoria para los clientes.</p>
              </div>
              <h1 class="titleSection">La fuerza de la marca Century 21</h1>
              <div class="col-xs-12 col-sm-12 video hijo">
                <p>Más de 120 oficinas en Venezuela, con más de 1.300 asesores inmobiliarios.</p>
                <p>Más de 8.400 oficinas en todo el mundo, con más de 140.000 asesores inmobiliarios.</p>
                <p>Comenzó a ayudar a los clientes a hacer excelentes negocios inmobiliarios en 1971. </p>
              </div>
            </section>
        </div>
        <div class="col-xs-12 col-sm-4">
            @include('common/proyectosLaterales')
            @include('common/inmueblesLaterales')
        </div>
    </div>
</div>

<!-- END GENERAL WRAPPER -->


@endsection
@section('js')
    <script >
        $(document).ready(function () {
          ////////////////////////////////////////////// Scroll Infinito ///////////////////////////////////////////////////////////////////////
      		window.sr = ScrollReveal();
      		sr.reveal('.hijo');
        });
    </script>
@endsection

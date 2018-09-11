@extends('base')

@section('content')

<div class="container">
    <div class="row">
        <!-- GO CONTENT INFO -->
        <div class="col-xs-12 col-sm-8">
              <div class="col-xs-12 col-sm-12">
                <h1 class="titleSection tittleEquipo">Nuestra Historia</h1>
                <div class="col-xs-12 col-sm-12">
                    <iframe  src="https://www.youtube.com/embed/u3DEiLfCZrc?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 primero">
                <h1 class="titleSection tittleEquipo" >Nos debemos a nuestros clientes</h1>
                <div class="col-xs-12 col-sm-12 hijo">
                  <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="col-xs-12">
                        <p class="contenido1" ><o class="cn600">Nuestra Misión es ayudar a los clientes a que hagan</o> <o class="stronger">excelentes negocios inmobiliarios.</o></p>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="col-xs-4 contllave">
                      <span class="llave">{</span>
                    </div>
                    <div class="col-xs-8">
                        <p class="contenido"><o class="cn600">Para lograr esta misión asumimos los retos de brindar a los clientes</o> <o class="stronger">un servicio inmobiliario extraordinario.</o></p>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="col-xs-4 contllave">
                      <span class="llave">{</span>
                    </div>
                    <div class="col-xs-8">
                        <p class="contenido"><o class="cn600">De esta manera buscamos que los clientes se conviertan en</o> <o class="stronger">clientes de por vida.</o></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12">
                <h1 class="titleSection ">Brindar un servicio extraordinario significa</h1>
                <div class="col-xs-12 col-sm-12 hijo">
                  <ul class="listaEquipo">
                    <b>
                    <li>Brindar a los clientes mucho más valor del que esperan.</li>
                    <li>Esmerarnos para conseguir las mejores oportunidades para los clientes.</li>
                    <li>Capacitarnos constantemente para brindar a los clientes conocimientos oportunos.</li>
                    <li>Apoyarnos en todas las oficinas y asesores que conforman el sistema C21, nacional e internacionalmente.</li>
                    </b>
                  </ul>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12">
                <h1 class="titleSection tittleEquipo">Para brindar un servicio extraordinario</h1>
                <div class="col-xs-12 col-sm-12 hijo">
                  <ul class="listaEquipo">
                    <b>
                    <li>En Century 21 Inmuebles Caracas nos basamos en estos valores:</li>
                    <li>El profesionalismo de nuestros asesores.</li>
                    <li>La honestidad en todas nuestras acciones.</li>
                    </b>
                  </ul>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12">
                <h1 class="titleSection tittleEquipo">Nos avala una trayectoria de constancia</h1>
                <div class="col-xs-12 col-sm-12 video hijo">
                  <ul class="listaEquipo">
                    <b>
                    <li>Century 21 Inmuebles Caracas fue fundada en 1999.</li>
                    <li>Somos pioneros de la marca Century 21 en Venezuela.</li>
                    <li>Siempre hemos estado entre las 10 primeras mejores oficinas de C21 en todo el país.</li>
                    <li>Hemos recibido el <strong>"Premio Centurión"</strong> en muchas oportunidades por la cantidad de negocios inmobiliarios concluidos de manera satisfactoria para los clientes.</li>
                    </b>
                  </ul>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 ultimo">
                <h1 class="titleSection tittleEquipo">La fuerza de la marca Century 21</h1>
                <div class="col-xs-12 col-sm-12 video hijo">
                  <ul class="listaEquipo">
                    <b>
                    <li>Más de 120 oficinas en Venezuela, con más de 1.300 asesores inmobiliarios.</li>
                    <li>Más de 8.400 oficinas en todo el mundo, con más de 140.000 asesores inmobiliarios.</li>
                    <li>Comenzó a ayudar a los clientes a hacer excelentes negocios inmobiliarios en 1971. </li>
                    </b>
                  </ul>
                </div>
              </div>

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

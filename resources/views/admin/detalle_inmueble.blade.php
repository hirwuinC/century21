@extends('admin/base_admin')

@section('content')
    <div class="contentDetail">
        <h2 class="titleSection">DETALLE DEL INMUEBLE</h2>
        <div class="row">
            <div class="col-xs-4">
                <p><span>Código MLS:</span> 831312</p>
                <p><span>Tipo de Negociacion:</span> Venta</p>
                <p><span>Tipo de Inmueble:</span> Casa</p>
                <p><span>Precio:</span> Bs 8.000.000</p>
                <p><span>Habitaciones:</span> 4</p>
                <p><span>Baños:</span> 2</p>
                <p><span>Puestos de Estacionamiento:</span> 2</p>
                <p><span>Metros de Construcción:</span> 10</p>
            </div>
            <div class="col-xs-4">
                <p><span>Metros de terreno:</span> 10</p>
                <p><span>Estado:</span> Miranda</p>
                <p><span>Ciudad:</span> Caracas-Sucre</p>
                <p><span>Urbanización:</span> Santa Eduvigis</p>
                <p><span>Oficina:</span> Avila Real Estate</p>
                <p><span>Visibilidad:</span> Activo</p>
                <p><span>Información referente al informe</span></p>
                <p><span>Oficina:</span> Caracas</p>
            </div>
            <div class="col-xs-4">
                <img src="{{ asset('images/img-demo.jpg')}}" alt="">
            </div>
        </div>
        <h2 class="titleSection">DESCRIPCIÓN DEL INMUEBLE</h2>
        <div class="row">
            <div class="col-xs-12">
                <p>Amplia y Luminosa Qta. de 2 plantas con amplios salones separados,estudio,gran cocina con pantry,pequeño anexo con
                    entrada independiente, Garaje para 4 vehiculos,2 techados,estar,patio. Excelente estado de Conservación y mantenimiento.</p>
                <p>Ubicada en zona de Alta revalorización, con todos los servicios y facilidades.Comprador motivado NEGOCIABLE !!!!</p>
            </div>
        </div>
        <h2 class="titleSection">UBICACIÓN DEL INMUEBLE</h2>
        <div class="row">
            <div class="col-xs-12">
                <iframe style="width: 100%" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6660.605222999498!2d-70.60553820000001!3d-33.415354099999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1508169047050" height="450" frameborder="0" allowfullscreen=""></iframe>
            </div>
        </div>
        <h2 class="titleSection">DATOS DE GESTIÓN DEL INMUEBLE</h2>
        <div class="row">
            <div class="col-xs-4">
                <p><span>Asesor Captador:</span> Asesor Genérico</p>
                <p><span>Asesor Cerrador:</span> Homero Hernandez</p>
                <p><span>Monto de Venta Final:</span> Bs 8.000.000</p>
                <p><span>%Comisión Captado:</span> 5%</p>
                <p><span>%Comisión Cerrador:</span> 5%</p>
            </div>
            <div class="col-xs-4">
                <p><span>Comisión Bruta:</span> 3.000.00</p>
                <p><span>Pago Casa Nacional:</span> 500.000</p>
                <p><span>Ingreso Neto Oficina:</span> 2.500.000</p>
                <p><span>Visitas Generadas:</span> 30</p>
                <p><span>Compradores Interesados:</span> 4</p>
            </div>
        </div>
        <h2 class="titleSection">INFORMES</h2>
        <div class="reports">
            <div class="row">
                <div class="col-xs-9">
                    <div class="alert alertGreen" role="alert">
                        <h5>Próximo informe debe ser enviando antes de: <span>16/12/2012</span></h5>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="buttons">
                        <button type="button" class="btnYellow noMargin" data-toggle="modal" data-target="#modalReport">NUEVO</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 listReports">
                    <div class="alert alertGrayLight" role="alert">
                        <div class="row">
                            <div class="col-xs-3"><h5>Informe 1</h5></div>
                            <div class="col-xs-3"><h5>16/12/2012</h5></div>
                            <div class="col-xs-6">
                                <ul>
                                    <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                    <li><button type="button" class="btnGraySmall">Enviar</button></li>
                                    <li class="circleYellow"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="alert alertGrayLight" role="alert">
                        <div class="row">
                            <div class="col-xs-3"><h5>Informe 1</h5></div>
                            <div class="col-xs-3"><h5>16/12/2012</h5></div>
                            <div class="col-xs-6">
                                <ul>
                                    <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                    <li class="circleGreen"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin/modals/reporte_modal')
@endsection
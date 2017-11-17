@extends('admin/base_admin')

@section('content')
    <h2 class="titleSection">inmuebles - <span>Agergar o quitar imágenes</span></h2>
    <section>
        <div class="row">
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="{{ asset('images/img-demo.jpg')}}" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="{{ asset('images/img-demo.jpg')}}" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="images/img-demo.jpg" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="{{ asset('images/img-demo.jpg')}}" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="images/img-demo-images.jpg" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="images/img-demo-images.jpg" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="images/img-demo-images.jpg" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="thumbProperty">
                    <div class="contentTop">
                        <img src="images/img-demo-images.jpg" alt="">
                    </div>
                    <div class="contentInfo">
                        <div class="buttonsAction">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction">
                                            Cargar
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btnAcction btnInactive">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="buttons">
                <div class="col-xs-3 right">
                    <a href="{{route('crear-inmueble-2')}}" type="button" class="btnYellow">Siguiente</a>
                </div>
            </div>
        </div>
    </section>
@endsection
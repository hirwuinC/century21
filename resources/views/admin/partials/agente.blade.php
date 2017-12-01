<div class="alert alertGrayLight" role="alert">
    <div class="row">
        <div class="col-xs-1">
            <img src="images/img-demo-agent.jpg" alt="">
        </div>
        <div class="col-xs-5"><h5>{{ $fullname }}</h5></div>
        <div class="col-xs-6">
            <ul>
                <li><a href="{{ route('crear-agente',['id'=>$asesor_id]) }}"><button type="button" class="btnGraySmall redirectAction">Crear Usuario</button></a></li>
                <li><a href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                <li><a href=""><i class="fa fa-times redError" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="alert alertGrayLight" role="alert">
    <div class="row">
        <div class="col-xs-1">
          {{$imagen}}
        </div>
        <div class="col-xs-5"><h5 style="margin-top:30px; margin-left:15px;">{{ $fullname }}</h5></div>
        <div class="col-xs-6">
            <ul style="margin-top:30px;">
                <li><a href="{{ route('crear-agente',['id'=>$asesor_id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                <li><a href=""><i class="fa fa-times redError" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-sm-{{$cantidad}}">
    <div class="thumbProject">
        <img src="{{asset('images/proyectos')}}/{{$img}}" alt="">
        <div class="caption">
            <div class="infoUbication">
                <h4>{{$title}}</h4>
                <h5>{{$zone}}</h5>
            </div>
            <div class="viewProject">
                <a href="{{ route('detalle_proyecto',$url) }}" >Ver proyecto</a>
            </div>
        </div>
    </div>
</div>

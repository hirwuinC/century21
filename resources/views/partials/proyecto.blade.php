<div class="col-sm-4">
    <div class="thumbProject">
        <img src="{{asset(images/)}}{{$img}}" alt="">
        <div class="caption">
            <div class="infoUbication">
                <h4>{{$title}}</h4>
                <h5>{{$zone}}</h5>
            </div>
            <div class="viewProject">
                <a href="{{ route('detalle_proyecto', 1) }}" >Ver proyecto</a>
            </div>
        </div>
    </div>
</div>
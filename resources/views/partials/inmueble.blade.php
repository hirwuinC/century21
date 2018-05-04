
<div class="thumbProperty hijo">
    <div class="contentTop">
        {{$img}}
        <div class="caption">
            <div class="businessType">
                <p>{{$type}}</p>
            </div>
            <div class="priceProject">
                {{$precio}}
            </div>
        </div>
    </div>
    <div class="contentInfo">
        <div class="infoProperty">
            {{$titulo}}
            <p><span><i class="fa fa-map-marker" aria-hidden="true"></i></span>{{$direccion}}</p>
        </div>
        <div class="characteristicsProperty">
            <ul>
                <li title="Metros de Construcción"><i class="fa fa-object-group"  aria-hidden="true"></i> {{$metros}} Mts</li>
                <li title="Habitaciones" ><i class="fa fa-bed" aria-hidden="true"></i> {{$cuartos}}</li>
                <li title="Baños" ><i class="fa fa-bath" aria-hidden="true"></i> {{$baños}}</li>
                <li title="Puestos de Estacionamiento" ><i class="fa fa-car" aria-hidden="true"></i> {{$estacionamientos}}</li>
            </ul>
        </div>
    </div>
</div>

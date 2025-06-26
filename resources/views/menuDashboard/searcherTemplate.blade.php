
@foreach ($productos as $producto)
<div class="row">
    <div class="col-sm-1">
      <img src="{{$producto['url_imagen']}}" alt="representacion de {{$producto['nombre_producto']}}" width="60" height="60">
    </div>
    <div class="col-sm-6">
      <div >
        <div class="d-flex align-items-center">
          <label for="" class="mt-2 d-block">&nbsp;&nbsp;{{$producto['nombre_producto']}}:</label>
          <span class="mr-4 mt-1">&nbsp;&nbsp;{{$producto['descripcion']}}</span>
        </div>

        <div><label for="">&nbsp;&nbsp;Precio:</label> <span><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span id="price-{{$producto['id_producto']}}">{{number_format($producto['precio'], 0, '', '.')}}</span></span></div>
      </div>
    </div>
    <div class="col-sm d-flex align-items-center">
      <button id="button_dataset_{{$producto['id_producto']}}" data-price="{{$producto['precio']}}" onclick="lessAndPlus('-','{{$producto['id_producto']}}')" class="btn btn-danger mr-2"><i class="fa-solid fa-minus"></i></button><input type="text" id="content_input-{{$producto['id_producto']}}" class="form-control input_info"  value="1"><button onclick="lessAndPlus('+','{{$producto['id_producto']}}')" class="btn btn-success ml-2"><i class="fa-solid fa-plus"></i></button><br>
      <button class="btn btn-success ml-2" onclick="addProductToCar('{{$producto['nombre_producto']}}','{{$producto['descripcion']}}','{{$producto['id_producto']}}','{{$producto['url_imagen']}}','{{$producto['precio']}}', '{{$producto['categoria']}}')"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Añadir producto</button>
    </div>
</div>
@endforeach

trabajando


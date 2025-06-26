<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Vender productos</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <div class="input-group mb-2">
              <input type="search" autocomplete="off" class="form-control form-control-lg" onkeyup="getSearch('{{route('searcher')}}', this.value)" placeholder="Buscar producto de venta..." id="input_search">
              <div class="input-group-append">
                  <button type="submit" class="btn btn-lg btn-default">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
          </div>
          <div id="container_search" class="product_search mt-1" ></div>

            <center>
                <h4 class="text-secondary"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Carrito de productos</h4>
                <div class="d-flex justify-content-end"><a onclick="emptyCart()" type="button" title="Vaciar carrito"><i class="fa-solid fa-trash text-danger"></i></a></div>
            </center>
            <hr>


            <div class="table-responsive">


              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Representación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Precio/unidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Carrito</th>
                  </tr>
                </thead>
                <tbody id="container_shop" data-precio="0">
                </tbody>
              </table>

            </div>

              <div class="p-5">

                <div class="row">
                  <div class="col-sm "><div class="d-flex"><h3>Total:</h3></div></div>
                  <div class="col-sm d-flex justify-content-end"><h3><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span id="price_total_car">0</span></h3></div>
                </div>
              </div>
              <div class="p-5">

                <div class="row">
                  <div class="col-sm "><div class="d-flex"><h3>Cambio:</h3></div></div>
                  <div class="col-sm d-flex justify-content-end"><h3><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span id="price_total_car_cambio">0</span></h3></div>
                </div>
              </div>
            <div class="d-flex justify-content-center">
            <button class="btn btn-success mr-2" onclick="sellProducts('{{route('sell')}}')" id="button_sell"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Vender productos</button>
            <button class="btn btn-info" onclick="prueba()"><i class="fa-solid fa-utensils" ></i>&nbsp;&nbsp;Ordenar a cocina</button>
            <button class="btn btn-primary ml-2" data-toggle="modal" data-target="#modal_cambio"><i class="fa-solid fa-repeat"></i>&nbsp;&nbsp;Cambio</button>
            </div>
            
        </div>



    </div>
    <!-- Modal -->
<div class="modal fade" id="modal_cambio"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="edit_price">cambio:</label>
          <input type="number" class="form-control" id="cambio"
              placeholder="Monto del cleinte..." autocomplete="off" name="costo">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button onclick="change()" type="button" class="btn btn-primary">Calcular cambio</button>
      </div>
    </div>
  </div>
</div>
</div>
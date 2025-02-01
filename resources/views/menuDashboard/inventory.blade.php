<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;Crear productos</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>
            <center>
                <h4 class="text-secondary"><i class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;Crear productos materia prima</h4>
            </center>
            <hr>

            <div class="row">

                <div class="col-sm">
                    <div class="form-group">
                        <label for="nombre_producto_inventario">Nombre producto:</label>
                        <input type="text" class="form-control" id="nombre_producto_inventario" placeholder="Nombre producto..." name="nombre" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="unidades_inventario">Unidades disponibles:</label>
                        <input type="number" class="form-control" id="unidades_inventario" placeholder="Ingresa la cantidad de unidades" name="unidades" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <label for="tope_min">Tope minimo notificación:</label>
                        <input type="number" class="form-control" id="tope_min" name="imagen_product" placeholder="Tope minimio..." autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="imagen_product">Precio costo:</label>
                        <input type="number" class="form-control" id="costo" name="imagen_product" placeholder="Precio costo..." autocomplete="off">
                    </div>
                </div>

            </div>

            <center>

                <button class="btn btn-primary" onclick="createInventory('{{ route('saveInventory') }}')"><i
                        class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;Crear inventario</button>
                <button class="btn btn-info" data-toggle="modal" data-target="#modal_edit_inventory"><i
                        class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;Editar inventario</button>
            </center>

            <div class="table-responsive">

                <table class="table" id="table_inventory">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre Producto</th>
                            <th scope="col">Unidades Disponibles</th>
                            <th scope="col">Fecha Creación</th>
                            <th scope="col">Tope Minimo</th>
                            <th scope="col">Precio Costo</th>
                            <th scope="col">Total/Producto</th>
                        </tr>
                    </thead>
                    <tbody>
        
                        @php
                            $flagg = 1;
                        @endphp
        
                        @foreach ($productos as $producto)
                            @php
                                $badge =
                                    $producto['unidades_disponibles'] <= $producto['tope_min']
                                        ? 'badge badge-danger'
                                        : 'badge badge-success';
                            @endphp
                            <tr>
                                <th scope="row">{{ $flagg }}</th>
                                <td>{{ $producto['nombre'] }}</td>
                                <td><span class="{{$badge}}">{{ $producto['unidades_disponibles'] }}</span></td>
                                <td>{{ $producto['fecha_creacion'] }}</td>
                                <td><span class="badge badge-warning">{{ $producto['tope_min'] }}</span></td>
                                <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{number_format($producto['precio_costo'], 0, '', '.')}}</td>
                                <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{number_format($producto['unidades_disponibles'] *  $producto['precio_costo'], 0, '', '.')}}</td>
                            </tr>
        
                            @php
                                $flagg++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>    
            </div>

            <div class="row p-5">

                <div class="col-sm">
                    <h3>Total inventario:</h3>
                </div>
                <div class="col-sm d-flex justify-content-end">
                    <h3><i
                            class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                    </h3>
                </div>
            </div>
        </div>



    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_edit_inventory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Editar inventario</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="select_item">Seleccionar item inventario:</label>
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" tabindex="9999"
                            style="width: 100%;" id="select_item_inventory">
                            <option selected="selected" value="selected">Seleccionar item</option>

                            @foreach ($productos as $producto)
                                <option value="{{ $producto['id_item'] }}">{{ $producto['nombre'] }}</option>
                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="adicion_unidades">Cambiar nombre item inventario:</label>
                        <input type="text" class="form-control" id="name_edit_inventory"
                            placeholder="Cambiar nombre item inventario..." autocomplete="off" name="nombre">
                    </div>

                    <div class="form-group">
                        <label for="adicion_unidades">Adicionar unidades:</label>
                        <input type="number" class="form-control" id="adicion_unidades"
                            placeholder="añadir unidades al inventario..." autocomplete="off" name="nombre">
                    </div>

                    <div class="form-group">
                        <label for="adicion_unidades">Establecer unidades:</label>
                        <input type="number" class="form-control" id="establishing_units"
                            placeholder="Establecer unidades inventario..." autocomplete="off" name="nombre">
                    </div>

                    <div class="form-group">
                        <label for="adicion_unidades">Modificar costo:</label>
                        <input type="number" class="form-control" id="price_costo"
                            placeholder="Modificar precio de costo..." autocomplete="off" name="costo">
                    </div>

                    <span class="text-secondary">Si desea eliminar un item de inventario recuerde que puede haber otros productos de venta asociados a dicho item...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="deleteInventory('{{route('deleteInventory')}}')" data-target="#modal_edit_inventory"><i class="fa-solid fa-xmark" ></i>&nbsp;&nbsp;Eliminar</button>
                    <button type="button" onclick="changeInventory('{{ route('editInventory') }}')"
                        class="btn btn-success"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Modificar</button>
                </div>
            </div>
        </div>
    </div>
</div>

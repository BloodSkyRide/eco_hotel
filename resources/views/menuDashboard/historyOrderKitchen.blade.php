<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-kitchen-set"></i>&nbsp;&nbsp;Historial de cocina</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <center>
                <h4 class="text-secondary">Órdenes de cocina</h4>
            </center>
            <hr>

            <div class="table-responsive">

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Producto</th>
                            <th scope="col"># items</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Nombre Cajero</th>
                            <th scope="col">Cédula Cajero</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item['nombre_producto'] }}</td>
                                <td>{{ $item['cantidad'] }}</td>
                                <td>{{ $item['descripcion'] }}</td>
                                <td>{{ $item['nombre_cajero'] }}</td>
                                <td>{{ $item['id_cajero'] }}</td>
                                <td>{{ $item['fecha'] }}</td>
                                <td>{{ $item['hora'] }}</td>

                                @php
                                    $class = '';

                                    if ($item['estado'] === 'preparacion') {
                                        $class = 'warning';
                                    } elseif ($item['estado'] === 'preparado') {
                                        $class = 'info';
                                    } 
                                    else if($item['estado'] === 'rechazado') $class = "danger";
                                    else {
                                        $class = 'success';
                                    }

                                    $button_start = '';
                                    $button_end = '';
                                    if ($id == '1093228865' || $id == '1091272724') {
                                        $button_start = '<a type="button" title="cambiar estado" onclick="openModalKitchen(' . $item["id_pedido"] . ')">';
                                        $button_end = '</a>';
                                    }
                                @endphp
                                <th>{!! $button_start !!}<span class="badge badge-{{ $class }}">{{ $item['estado'] }}</span>{!! $button_end !!}</th>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>



    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_state_kitchen" tabindex="-9999" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar estado de Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content_modal_state_kitchen" data-id="">

                    <label for="state_kitchen">Cambiar estado:</label>

                    <select class="form-control" id="state_kitchen" name="state_kitchen">
                        <option value="">Seleccione un estado</option>
                        <option value="preparacion">Preparación</option>
                        <option value="preparado">Preparado</option>
                        <option value="despachado">Despachado</option>
                        <option value="rechazado">Rechazado</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button"
                        onclick="sendStateKitchen('{{ route('changeState') }}', 'Aceptar')"
                        class="btn btn-success"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>

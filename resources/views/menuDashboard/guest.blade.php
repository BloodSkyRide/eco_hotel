<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-list"></i>&nbsp;&nbsp;Crear productos</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">

            <hr>
            <center>
                <h3>Comida de empleados</h3>
            </center>

            <div class="form-group">
                <label for="select_item">Seleccionar productos de venta:</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                    style="width: 100%;" id="select_item_sell">
                    <option selected="selected" value="selected">Seleccionar item</option>
{{-- 
                    @foreach ($products as $producto)
                        <option value="{{ $producto['id_producto'] }}">{{ $producto['nombre_producto'] }}</option>
                    @endforeach --}}

                </select>

            </div>
            <div class="form-group">
                <label for="unidades_inventario">Nombre empleado:</label>
                <input type="text" class="form-control" id="name_employee" placeholder="Nombre del empleado"
                    name="unidades" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="unidades_inventario">Unidades:</label>
                <input type="number" class="form-control" id="units_employee" placeholder="unidades a asignar"
                    name="unidades" autocomplete="off">
            </div>

            <center><button onclick="discountFoodEmployee('{{route('insertFood')}}')" class="btn btn-info"><i class="fa-solid fa-utensils"></i>&nbsp;&nbsp;Asignar comida</button>
            </center>

            <hr>

            <center>
                <h3>Alimentación entregada</h3>
            </center>

        </div>

    </div>
</div>

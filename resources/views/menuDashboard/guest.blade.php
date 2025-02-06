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
                <h3>Registro de huespedes</h3>
            </center>

            <div class="form-group">


                <div class="row">
                    {{-- COLUMNA 1 --}}
    
                    <div class="col">
                        <div class="form-group">
                            <label for="nombre_producto">Nombre huesped:</label>
                            <input type="text" class="form-control" id="nombre_huesped" placeholder="nombre huesped..."
                                autocomplete="off" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="precio_producto">Apellido huesped:</label>
                            <input type="text" class="form-control" id="apellido_huesped" placeholder="apellido huesped..."
                                autocomplete="off" name="apellido huesped...">
                        </div>
    
                        <div class="form-group">
                            <label for="imagen_product">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" id="date" name="date"
                                autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="imagen_product">Cédula o documento:</label>
                            <input type="number" class="form-control" id="documento" name="documento" placeholder="Documento de identidad..."
                                autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="imagen_product">Correo electrónico:</label>
                            <input type="email" class="form-control" id="correo" name="documento" placeholder="Correo electronico..."
                                autocomplete="off">
                        </div>



    
                    </div>
    
                    {{-- COLUMNA 2 --}}
                    <div class="col">
    
                        <div class="row">
    
                            <div class="col-md-9">
    
                                <div class="form-group">
                                    <label for="imagen">Origien:</label>
                                    <input type="email" class="form-control" id="origen" name="origien"
                                    autocomplete="off" placeholder="origen del huesped...">
                                </div>
                                <div class="form-group">
                                    <label for="imagen">Destino:</label>
                                    <input type="email" class="form-control" id="destino" name="destino"
                                    autocomplete="off" placeholder="destino del huesped...">
                                </div>

    
                                <div class="form-group">
                                    <label for="select_item">Estado civil:</label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" style="width: 100%;" id="select_item">
                                        <option selected="selected" value="selected">Seleccionar item</option>
                                            <option value="soltero">Solter@</option>
                                            <option value="Casado">Casad@</option>
                                            <option value="Viudo">Viud@</option>
                                            <option value="Divorciado">Divorsiad@</option>
                                            <option value="Union libre">Union libre</option>
                                    </select>
    
                                </div>

                                <div class="form-group">
                                    <label for="imagen">Número de contacto:</label>
                                    <input type="text" class="form-control" id="destino" name="destino"
                                    autocomplete="off" placeholder="numero de contacto">
                                </div>

                                <div class="form-group">
                                    <label for="imagen">Destino:</label>
                                    <input type="email" class="form-control" id="destino" name="destino"
                                    autocomplete="off" placeholder="destino del huesped...">
                                </div>
                                
    

                            </div>
    
                        </div>

                    </div>
    
                </div>


                <button class="btn btn-primary" onclick="addItemInventory()" class="fa-solid fa-plus"><i
                    class="fa-solid fa-plus"></i>&nbsp;&nbsp;Añadir item</button>
                <div class="col-md">

                    <div class="table-responsive mt-3">

                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">item</th>
                                    <th scope="col">Descuento</th>
                                </tr>
                            </thead>
                            <tbody id="container_tr">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            

        </div>

    </div>
</div>

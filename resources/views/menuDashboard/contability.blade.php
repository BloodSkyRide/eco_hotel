<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-list"></i>&nbsp;&nbsp;Contabilidad</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">FECHA</th>
                        <th scope="col">TOTAL VENTA</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            
                        <tr>
                          <td>{{$item['fecha']}}</td>
                          <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span class="badge badge-success">{{$item['total_venta_dia']}}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>

            <div class="row p-5">

                <div class="col-sm">
                    <h3>Total venta del mes:</h3>
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
<div class="modal fade" id="modal_info" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg bg-success">
          <h5 class="modal-title" id="titulo_modal"></h5>
          <button type="button" class="close" onclick="closeModalSecure()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span class="text-secondary" id="span_id" data-id=""></span>
          <br>
          <br>
          <div class="table-responsive">
            
            <table class="table" id="table_guests">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre item materia prima</th>
                        <th scope="col">Cantidad de unidades de descuento</th>
                    </tr>
                </thead>
                <tbody id="tbody_id">
                </tbody>
            </table>

        </div>

        <hr>
        <center><h3 class="text-secondary">Modificar producto de venta</h3></center>
        <div class="row">
            <div class="col-sm">
                <div class="form-group">
                    <label for="edit_price">Modificar nombre producto:</label>
                    <input type="text" class="form-control" id="edit_name"
                        placeholder="Modificar nombre item..." autocomplete="off" name="costo">
                </div>
        
                <div class="form-group">
                    <label for="edit_description">Descripción del producto:</label>
                    <textarea name="descripcion" id="edit_description" cols="30" rows="2" class="form-control"
                        autocomplete="off" placeholder="Descripción del producto..."></textarea>
                </div>
            </div>
            <div class="col-sm">
                <div class="form-group">
                    <label for="edit_price">Modificar costo:</label>
                    <input type="number" class="form-control" id="edit_price"
                        placeholder="Modificar precio de costo..." autocomplete="off" name="costo">
                </div>
        
                <div class="form-group">
                    <label for="edit_imagen_product">Modificar imagen de producto:</label>
                    <input type="file" class="form-control" id="edit_imagen_product" name="imagen_product"
                        autocomplete="off">
                </div>
            </div>
        </div>

        <div id="previewContainer">
            <center><img id="imagePreview2" src="" alt="Previsualización de imagen"
                    style="display: none; max-width: 150px; margin-top: 10px; max-height: 150px"></center>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModalSecure()">Cerrar</button>
          <button type="button" onclick="deleteProductSeller('{{ route('deleteCompound') }}')"
          class="btn btn-danger" data-dismiss="modal"><i
              class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Eliminar</button>
      <button type="button" onclick="modifyItemCompound('{{ route('editProductCompund') }}')"
          class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Modificar</button>
        </div>
      </div>
    </div>
  </div>
</div>

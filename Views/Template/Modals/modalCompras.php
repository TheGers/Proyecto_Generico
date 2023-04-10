<!-- Modal -->
<div class="modal fade" id="modalFormCompras" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- ----------------------- FORMULARIO DE COMPRAS /------------------------- -->
            <div class="modal-body">
                <form id="formCompras" name="formCompras" class="form-horizontal">
                    <input type="hidden" id="idCompra" name="idCompra" value="">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="listProveedor">Proveedor</label>
                            <select class="form-control" data-live-search="true" id="listProveedor" name="listProveedor">
                                <option selected disabled></option>
                                <?php
                                include("Config/Config.php");
                                $sql = $conexion->query("SELECT * FROM tbl_personas");
                                while ($resultado = $sql->fetch_assoc()) {
                                    if ($resultado['COD_TIPO_PERSONA'] == '2') {
                                        // Procesar los datos del proveedor
                                        echo "<option value='" . $resultado['COD_PERSONA'] . "'>" . $resultado['COD_TIPO_PERSONA'] . $resultado['NOMBRE'] . "</option>";
                                    } else {
                                        // Mostrar un error o redirigir a una página de error
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listProducto">Producto</label>
                            <select class="form-control" data-live-search="true" id="listProducto" name="listProducto"></select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class=" control-label">Precio</label>
                            <input class="form-control" id="txtPrecio" name="txtPrecio" type="text">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Cantidad</label>
                            <input class="form-control" id="txtCantidad" name="txtCantidad" type="number">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">SubTotal</label>
                            <input class="form-control" id="txtSubtotal" name="txtSubtotal" type="text">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary" id="btnAgregar" type="button">Agregar</button>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="tile-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" id="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre Producto</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Sub Total</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Total</label>
                                <input class="form-control" id="txtTotal" name="txtTotal" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText" onclick="return validarFormulario();">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>



<!-- Modal PARA MOSTRAR UN DATO -->
<div class="modal fade" id="modalViewCompras" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de Compras</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Proveedor:</td>
                            <td id="celProveedor"></td>
                        </tr>
                        <tr>
                            <td>NProducto:</td>
                            <td id="celProducto"></td>
                        </tr>
                        <tr>
                            <td>Descripcion:</td>
                            <td id="celDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Subtotal:</td>
                            <td id="celSubtotal"></td>
                        </tr>
                        <tr>
                            <td>Impuesto:</td>
                            <td id="celImpuesto"></td>
                        </tr>
                        <tr>
                            <td>Descuento:</td>
                            <td id="celDescuento"></td>
                        </tr>
                        <tr>
                            <td>Total:</td>
                            <td id="celTotal"></td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td id="celStatus"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
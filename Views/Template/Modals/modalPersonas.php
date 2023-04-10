<div class="modal fade" id="modalFormPersonas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPersonas" name="formPersonas" class="form-horizontal">
                    <input type="hidden" id="idPersona" name="idPersona" value="">
                    <p class="text-primary">Todos los campos son obligatorios.</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="listTipoPersona">Tipo Persona <span class="required">*</span></label>
                            <select class="form-control" data-live-search="true" id="listTipoPersona"
                                name="listTipoPersona">
                                <option selected disabled></option>
                <?php
                 include("Config/Config.php");
                 $sql =$conexion->query("SELECT * FROM tbl_tipo_persona");
                 while($resultado = $sql->fetch_assoc()){
                    echo "<option value='".$resultado['idTipo']."'>".$resultado['TIPO_PERSONA']."</option>";

                 }
              ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Nombres</label>
                            <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre"
                                required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="listgenero">Genero:</label>
                            <select class="form-control selectpicker" id="listgenero" name="listgenero" required>
                                <option value="FEMENINO">FEMENINO</option>
                                <option value="MASCULINO">MASCULINO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="datefecha">Fecha Nacimiento: <span class="required">*</span></label>
                            <input type="date" class="form-control" id="datefecha" name="datefecha" required="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="listTipoIdentificacion">Tipo Identificacion <span class="required">*</span></label>
                            <select class="form-control" data-live-search="true" id="listTipoIdentificacion"
                                name="listTipoIdentificacion">
                                <option selected disabled></option>
                <?php
                 include("Config/Config.php");
                 $sql =$conexion->query("SELECT * FROM tbl_tipo_identificacion");
                 while($resultado = $sql->fetch_assoc()){
                    echo "<option value='".$resultado['id']."'>".$resultado['TIPO_IDENTIFICACION']."</option>";

                 }
              ?>
                            
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtIdentificacion">Identificación</label>
                            <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion"
                                required="">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="listStatus">Status</label>
                        <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i><span
                                id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombre Producto:</td>
                            <td id="celNombre"></td>
                        </tr>
                        <tr>
                            <td>Categoría:</td>
                            <td id="celCategoria"></td>
                        </tr>
                        <tr>
                            <td>Descripción:</td>
                            <td id="celDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Precio:</td>
                            <td id="celPrecio"></td>
                        </tr>
                        <tr>
                            <td>Existencia:</td>
                            <td id="celStock"></td>
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
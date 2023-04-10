let tableCompras;
let rowTable = "";
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

tableCompras = $('#tableCompras').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Compras/getCompras",
        "dataSrc": ""
    },
    "columns": [
        { "data": "COD_COMPRA" },
        { "data": "TOTAL" },
        { "data": "FECHA_CREACION" },
        { "data": "options" }
    ], 
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr": "Copiar",
            "className": "btn btn-secondary"
        }, {
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr": "Esportar a Excel",
            "className": "btn btn-success"
        }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr": "Esportar a PDF",
            "className": "btn btn-danger"
        }, {
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr": "Esportar a CSV",
            "className": "btn btn-info"
        }
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 12,
    "order": [[0, "desc"]]


});

// -----------------------------------------------------EVENTOS--------------------------------------------------------------
window.addEventListener('load', function () {

    if (document.querySelector("#formCompras")) {
        let formCompras = document.querySelector("#formCompras");
        formCompras.onsubmit = function (e) {
            e.preventDefault();
            let intCOD_PERSONA = document.querySelector('#listProveedor').value;
            let strCAI = document.querySelector('#txtCai').value;
            let strNUMERO_FACTURA = document.querySelector('#txtNumerofactura').value;
            let strDESCRIPCION = document.querySelector('#txtDescripcion').value;
            let intSUBTOTAL = document.querySelector('#txtSubtotal').value;
            let intIMPUESTO = document.querySelector('#txtImpuesto').value;
            let intDESCUENTO = document.querySelector('#txtDescuento').value;
            let intTOTAL = document.querySelector('#txtTotal').value;
            let intstatus = document.querySelector('#listStatus').value;
            if (intCOD_PERSONA == '' || strCAI == '' || strNUMERO_FACTURA == '' || strDESCRIPCION == '' ||
                intSUBTOTAL == '' || intIMPUESTO == '' || intDESCUENTO == '' || intTOTAL == '' || intstatus == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Compras/setCompra';
            let formData = new FormData(formCompras);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 5 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("", objData.msg, "success");
                        document.querySelector("#idCompra").value = objData.COD_COMPRA;
                        if (rowTable == "") {
                            tableCompras.api().ajax.reload();
                        } else {
                            htmlStatus = intstatus == 1 ?
                                '<span class="badge badge-success">Activo</span>' :
                                '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = intCOD_PERSONA;
                            rowTable.cells[2].textContent = strCAI;
                            rowTable.cells[3].textContent = strNUMERO_FACTURA;
                            rowTable.cells[4].textContent = strDESCRIPCION;
                            rowTable.cells[5].textContent = intSUBTOTAL;
                            rowTable.cells[6].textContent = intIMPUESTO;
                            rowTable.cells[7].textContent = intDESCUENTO;
                            rowTable.cells[8].textContent = intTOTAL;
                            rowTable.cells[9].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    
    fntPersonas();
    fntProductos();
}, false);

// --------------------------------------------VER INFORMACION O DETALLE DE LA COMPRAS--------------------------------------------

function fntViewInfo(idCompra) {
    let request = (window.XMLHttpRequest) ?
        new XMLHttpRequest() :
        new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Compras/getCompra/' + idCompra;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 5 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let objCompra = objData.data;
                let estadoCompra = objCompra.status == 1 ?
                    '<span class="badge badge-success">Activo</span>' :
                    '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celProveedor").innerHTML = objCompra.tbl_tipo_persona;
                document.querySelector("#celCai").innerHTML = objCompra.CAI;
                document.querySelector("#celNumeroFactura").innerHTML = objCompra.NUMERO_FACTURA;
                document.querySelector("#celDescripcion").innerHTML = objCompra.DESCRIPCION;
                document.querySelector("#celSubtotal").innerHTML = objCompra.SUBTOTAL;
                document.querySelector("#celImpuesto").innerHTML = objCompra.IMPUESTO;
                document.querySelector("#celDescuento").innerHTML = objCompra.DESCUENTO;
                document.querySelector("#celTotal").innerHTML = objCompra.TOTAL;
                document.querySelector("#celStatus").innerHTML = estadoCompra;
                $('#modalViewCompras').modal('show');

            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}



// ------------------------------------------LISTAR PROVEEDORES EN EL SELECTOR DE COMPRAS-------------------------------------------

function fntPersonas() {
    if (document.querySelector('#listProveedor')) {
        let ajaxUrl = base_url + '/Personas/getSelectPersonas';
        let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 5 && request.status == 200) {
                document.querySelector('#listProveedor').innerHTML = request.responseText;
                $('#listProveedor').selectpicker('render');
            }
        }
    }
}

// ----------------------------------------LISTAR PRODUCTOS EN EL SELECTOR DE COMPRAS--------------------------------------------

function fntProductos() {
    if (document.querySelector('#listProducto')) {
        let ajaxUrl = base_url + '/Productos/getSelectProductos';
        let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#listProducto').innerHTML = request.responseText;
                $('#listProducto').selectpicker('render');
            }
        }
    }
}

// --------------------------------------------------ABRIR EL MODAL------------------------------------------------------------------

function openModal() {
    rowTable = "";
    document.querySelector('#idCompra').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Compra";
    document.querySelector("#formCompras").reset();
    $('#modalFormCompras').modal('show');

}

// -----------------------------------------------------------------------------------------------------------------------------------


let tableVentas;
let rowTable = "";
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableVentas = $('#tableVentas').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Ventas/getVentas",
        "dataSrc":""
    },
    "columns":[
        {"data":"COD_VENTA"},
        {"data":"COD_PERSONA"},
        {"data":"COD_TIPO_MOVIMIENTO"},
        {"data":"DESCRIPCION"},
        {"data":"SUBTOTAL"},
        {"data":"IMPUESTO"},
        {"data":"DESCUENTO"},
        {"data":"COD_TIPO_PAGO"},
        {"data":"NUMERO_COMPROBANTE"},
        {"data":"status"},
        {"data":"options"}
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary"
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success"
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger"
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Esportar a CSV",
            "className": "btn btn-info"
        }
    ],
    "resonsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"desc"]]  

    
});
window.addEventListener('load', function () {

},false);
function openModal() {
    rowTable = "";
    document.querySelector('#idVenta').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Venta";
    document.querySelector("#formVentas").reset();

    $('#modalFormVentas').modal('show');

}
let tableRegistros;
let rowTable = "";
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
    tableRegistros = $('#tableRegistros').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Personas/getPersonas",
        "dataSrc":""
    },
    "columns":[
        {"data":"COD_PERSONA"},
        {"data":"COD_TIPO_PERSONA"},
        {"data":"NOMBRE"},
        {"data":"GENERO"},
        {"data":"FECHA_NACIMIENTO"},
        {"data":"COD_TIPO_IDENTIFICACION"},
        {"data":"IDENTIFICACION"},
        {"data":"COD_DIRECCION"},
        {"data":"COD_TELEFONO"},
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
    if (document.querySelector("#formPersonas")) {
        let formPersonas = document.querySelector("#formPersonas");
        formPersonas.onsubmit = function (e) {
            e.preventDefault();
            let intCOD_TIPO_PERSONA = document.querySelector('#listTipoPersona').value;
            let strNOMBRE = document.querySelector('#txtNombre').value;
            let intGENERO = document.querySelector('#listgenero').value;
            let intFECHA_NACIMIENTO = document.querySelector('#datefecha').value;
            let intCOD_TIPO_IDENTIFICACION = document.querySelector('#listTipoIdentificacion').value;
            let intIDENTIFICACION = document.querySelector('#txtIdentificacion').value;
            let intESTADO = document.querySelector('#listStatus').value;
            if (intCOD_TIPO_PERSONA == '' || strNOMBRE == '' || intGENERO == '' || intFECHA_NACIMIENTO == ''
            || intCOD_TIPO_IDENTIFICACION == ''    || intIDENTIFICACION == '' || intESTADO == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Personas/setPersona';
            let formData = new FormData(formPersonas);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData.msg ,"success");
                        document.querySelector("#idPersona").value = objData.COD_PERSONA;

                        if(rowTable == ""){
                            tableRegistros.api().ajax.reload();
                        }else{
                           htmlStatus = intESTADO == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = intCOD_TIPO_PERSONA;
                            rowTable.cells[2].textContent = strNOMBRE;
                            rowTable.cells[3].textContent = intGENERO;
                            rowTable.cells[4].textContent = intFECHA_NACIMIENTO;
                            rowTable.cells[5].textContent = intCOD_TIPO_IDENTIFICACION;
                            rowTable.cells[6].textContent = intIDENTIFICACION;
                            rowTable.cells[7].innerHTML =  htmlStatus;
                            rowTable = ""; 
                        }
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;

            }
        }
    }
},false);
function openModal() {
    rowTable = "";
    document.querySelector('#idPersona').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Registro";
    document.querySelector("#formPersonas").reset();

    $('#modalFormPersonas').modal('show');

}
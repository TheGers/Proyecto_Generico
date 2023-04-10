let tableProductos;
let rowTable = "";

$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableProductos = $('#tableProductos').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Productos/getProductos",
        "dataSrc": ""
    },
    "columns": [
        { "data": "COD_PRODUCTO" },
        { "data": "NOMBRE_PRODUCTO" },
        { "data": "COD_CATEGORIA" },
        { "data": "DESCRIPCION" },
        { "data": "PRECIO" },
        { "data": "EXISTENCIA" },
        { "data": "status" },
        { "data": "options" }
    ],
    "columnDefs": [
        { 'className': "textcenter", "targets": [3] },
        { 'className': "textright", "targets": [4] },
        { 'className': "textcenter", "targets": [5] }
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr": "Copiar",
            "className": "btn btn-secondary",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5, 6]
            }
        }, {
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr": "Esportar a Excel",
            "className": "btn btn-success",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5, 6]
            }
        }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr": "Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5, 6]
            }
        }, {
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr": "Esportar a CSV",
            "className": "btn btn-info",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5, 6]
            }
        }
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});
window.addEventListener('load', function () {

    if (document.querySelector("#formProductos")) {
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function (e) {
            e.preventDefault();
            let strNOMBRE_PRODUCTO = document.querySelector('#txtNombre').value;
            let strDESCRIPCION = document.querySelector('#txtDescripcion').value;
            let intPRECIO = document.querySelector('#txtPrecio').value;
            let intEXISTENCIA = document.querySelector('#txtStock').value;
            let intESTADO = document.querySelector('#listStatus').value;
            if (strNOMBRE_PRODUCTO == '' || strDESCRIPCION == '' || intPRECIO == '' || intEXISTENCIA == '' || intESTADO == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Productos/setProducto';
            let formData = new FormData(formProductos);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData.msg ,"success");
                        document.querySelector("#idProducto").value = objData.COD_PRODUCTO;

                        if(rowTable == ""){
                            tableProductos.api().ajax.reload();
                        }else{
                           htmlStatus = intESTADO == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strNOMBRE_PRODUCTO;
                            rowTable.cells[2].textContent = strDESCRIPCION;
                            rowTable.cells[3].textContent = smony+intPRECIO;
                            rowTable.cells[4].textContent = intEXISTENCIA;
                            rowTable.cells[5].innerHTML =  htmlStatus;
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



    
    fntCategorias();
}, false);
function fntViewInfo(idProducto){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
              
                let objProducto = objData.data;
                let estadoProducto = objProducto.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celNombre").innerHTML = objProducto.NOMBRE_PRODUCTO;
                document.querySelector("#celCategoria").innerHTML = objProducto.tbl_categoria;
                document.querySelector("#celDescripcion").innerHTML = objProducto.DESCRIPCION;
                document.querySelector("#celPrecio").innerHTML = objProducto.PRECIO;
                document.querySelector("#celStock").innerHTML = objProducto.EXISTENCIA;
                document.querySelector("#celStatus").innerHTML = estadoProducto;
                $('#modalViewProducto').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}
function fntEditInfo(element,idProducto){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.COD_PRODUCTO;
                document.querySelector("#txtNombre").value = objProducto.NOMBRE_PRODUCTO;
                document.querySelector("#listCategoria").value = objProducto.COD_CATEGORIA;
                document.querySelector("#txtDescripcion").value = objProducto.DESCRIPCION;
                document.querySelector("#txtPrecio").value = objProducto.PRECIO;
                document.querySelector("#txtStock").value = objProducto.EXISTENCIA;
                document.querySelector("#listStatus").value = objProducto.status;
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
              

                    
                $('#modalFormProductos').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
function fntEditInfo(element,idProducto){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
               
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.COD_PRODUCTO;
                document.querySelector("#txtNombre").value = objProducto.NOMBRE_PRODUCTO;
                document.querySelector("#listCategoria").value = objProducto.COD_CATEGORIA;
                document.querySelector("#txtDescripcion").value = objProducto.DESCRIPCION;
                document.querySelector("#txtPrecio").value = objProducto.PRECIO;
                document.querySelector("#txtStock").value = objProducto.EXISTENCIA;
                document.querySelector("#listStatus").value = objProducto.status;
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
           
                $('#modalFormProductos').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}



function fntDelInfo(idProducto){
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/delProducto';
            let strData = "idProducto="+idProducto;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableProductos.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}

// ---------------------------------------------LISTAR CATEGORIAS EN EL SELECTOR DE PRODUCTOS-------------------------------------------
function fntCategorias() {
    if (document.querySelector('#listCategoria')) {
        let ajaxUrl = base_url + '/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}



// --------------------------------------------------ABRIR EL MODAL--------------------------------------------



function openModal() {
    rowTable = "";
    document.querySelector('#idProducto').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProductos").reset();

    $('#modalFormProductos').modal('show');

}


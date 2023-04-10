<?php
class Compras extends Controllers
{
	// -----------------------------------------------------CONSTRUCTOR-------------------------------------------------------
	
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location:'.base_url().'/login');
		}
		getPermisos(5);
	}

	// -------------------------------------------------------MOSTRAR---------------------------------------------------------

	public function Compras()
	{
		if (empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Compras";
		$data['page_title'] = "Compras";
		$data['page_name'] = "compras";
		$data['page_functions_js'] = "functions_compras.js";
		$this->views->getView($this, "compras", $data);
	}

	// -------------------------------------------------------OBTENER-----------------------------------------------------------
	
	public function getCompras()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectCompras();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				if ($arrData[$i]['status'] == 1) 
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}else{
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				if ($_SESSION['permisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['COD_COMPRA'].')" title="Ver "><i class="far fa-eye"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	// ----------------------------------------------------ACTUALIZAR--------------------------------------------------------
	
	public function setCompra()
	{
		if ($_POST) {
			if (empty($_POST['listProveedor']) || empty($_POST['txtCai']) || empty($_POST['txtNumerofactura']) || empty($_POST['txtDescripcion']) || empty($_POST['txtSubtotal']) || empty($_POST['txtImpuesto']) || empty($_POST['txtDescuento']) || empty($_POST['txtTotal']) || empty($_POST['listStatus'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$intCOD_COMPRA = intval($_POST['COD_COMPRA']);
				$intCOD_PERSONA = intval($_POST['listProveedor']);
				$strCAI = strClean($_POST['txtCai']);
				$strNUMERO_FACTURA = strClean($_POST['txtNumerofactura']);
				$strDESCRIPCION = strClean($_POST['txtDescripcion']);
				$intSUBTOTAL = intval($_POST['txtSubtotal']);
				$intIMPUESTO = intval($_POST['txtImpuesto']);
				$intDESCUENTO = intval($_POST['txtDescuento']);
				$intTOTAL = intval($_POST['txtTotal']);
				$intstatus = intval($_POST['listStatus']);
				$request_compra = "";
				if ($intCOD_COMPRA == 0) {
					$option = 1;
					if ($_SESSION['permisosMod']['w']) {
						$request_compra = $this->model->insertCompras(
							$intCOD_COMPRA,
							$intCOD_PERSONA,
							$strCAI,
							$strNUMERO_FACTURA,
							$strDESCRIPCION,
							$intSUBTOTAL,
							$intIMPUESTO,
							$intDESCUENTO,
							$intTOTAL,
							$intstatus,
						);	
					}
					
				} else {
					$option = 2;
					if ($_SESSION['permisosMod']['u']) {
						$request_compra = $this->model->updateCompras(
							$intCOD_COMPRA,
							$intCOD_PERSONA,
							$strCAI,
							$strNUMERO_FACTURA,
							$strDESCRIPCION,
							$intSUBTOTAL,
							$intIMPUESTO,
							$intDESCUENTO,
							$intTOTAL,
							$intstatus,
						);
					}
				}
					if($request_compra > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'COD_COMPRA' => $request_compra, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'COD_COMPRA' => $intCOD_COMPRA, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_compra == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe el producto Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	// -----------------------------------------------------------------------------------------------------------------------------

	public function getcompra($COD_COMPRA)
	{
		if ($_SESSION['permisosMod']['r']) {
			$COD_COMPRA = intval($COD_COMPRA);
			if ($COD_COMPRA > 0) {
				$arrData = $this->model->selectCompra($COD_COMPRA);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------

}

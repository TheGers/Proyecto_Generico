<?php
class Productos extends Controllers
{


	// -------------------------------------------------CONSTRUCTOR--------------------------------------------------------
	
	public function __construct()
	{
		parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(2);
	}

	// ---------------------------------------------------MOSTRAR----------------------------------------------------------

	public function Productos()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Productos";
		$data['page_title'] = "Productos";
		$data['page_name'] = "productos";
		$data['page_functions_js'] = "functions_productos.js";
		$this->views->getView($this, "productos", $data);
	}
	
	// ---------------------------------------------------OBTENER-----------------------------------------------------------
	
	public function getProductos()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectProductos();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if($arrData[$i]['status'] == 1)
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}else{
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				$arrData[$i]['PRECIO'] = SMONEY.' '.formatMoney($arrData[$i]['PRECIO']);
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['COD_PRODUCTO'].')" title="Ver "><i class="far fa-eye"></i></button>';
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['COD_PRODUCTO'].')" title="Editar "><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['COD_PRODUCTO'].')" title="Eliminar "><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
// -----------------------------------------------------ACTUALIZAR-------------------------------------------------
	
	public function setProducto(){
		if($_POST){
			
			if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']) || empty($_POST['listCategoria']) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{
				$idProducto = intval($_POST['idProducto']);
					$strNOMBRE_PRODUCTO = strClean($_POST['txtNombre']);
					$intCOD_CATEGORIA = intval($_POST['listCategoria']);
					$strDESCRIPCION = strClean($_POST['txtDescripcion']);
					$intPRECIO = strClean($_POST['txtPrecio']);
					$intEXISTENCIA = intval($_POST['txtStock']);
					$intESTADO = intval($_POST['listStatus']);
					$request_producto = "";
				
					if($idProducto == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_producto = $this->model->insertProducto($strNOMBRE_PRODUCTO, 
																		$intCOD_CATEGORIA, 
																		$strDESCRIPCION, 
																		$intPRECIO,
																		$intEXISTENCIA, 
																		$intESTADO );
						}
					}else{
						$option = 2;
							if($_SESSION['permisosMod']['u']){
								$request_producto = $this->model->updateProducto($idProducto,
																			$strNOMBRE_PRODUCTO,
																			$intCOD_CATEGORIA, 
																			$strDESCRIPCION, 
																			$intPRECIO,
																			$intEXISTENCIA, 
																			$intESTADO);
						}
					}
					if($request_producto > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'COD_PRODUCTO' => $request_producto, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'COD_PRODUCTO' => $idProducto, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_producto == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe el producto Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	
	// -------------------------------------------------------------------------------------------------------------------------

	public function delProducto(){
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$intCOD_PRODUCTO = intval($_POST['idProducto']);
				$requestDelete = $this->model->deleteProducto($intCOD_PRODUCTO);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	// -------------------------------------------------------------------------------------------------------------------------

	public function getProducto($COD_PRODUCTO){
		if($_SESSION['permisosMod']['r']){
			$COD_PRODUCTO = intval($COD_PRODUCTO);
			if($COD_PRODUCTO > 0){
				$arrData = $this->model->selectProducto($COD_PRODUCTO);
				if(empty($arrData)){
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
// -------------------------------------------------------------------------------------------------------------------------

public function getSelectProductos(){
	$htmlOptions = "";
	$arrData = $this->model->selectProductos();
	if(count($arrData) > 0){
		for ($i=0; $i < count($arrData); $i++){
			if($arrData[$i]['status'] == 1){
				$htmlOptions .= '<option value="'.$arrData[$i]['COD_PRODUCTO'].'">'.$arrData[$i]['NOMBRE_PRODUCTO'].'</option>';
			}
		}
	}
	echo $htmlOptions;
	die();
}

// -------------------------------------------------------------------------------------------------------------------------


}

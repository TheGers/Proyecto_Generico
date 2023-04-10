<?php
class Personas extends Controllers
{
	
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

	public function Personas()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Personas";
		$data['page_title'] = "Personas";
		$data['page_name'] = "personas";
		$data['page_functions_js'] = "functions_personas.js";
		$this->views->getView($this, "personas", $data);
	}
	
	
	public function getPersonas()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectPersonas();
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
				
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['COD_PERSONA'].')" title="Ver "><i class="far fa-eye"></i></button>';
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['COD_PERSONA'].')" title="Editar "><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['COD_PERSONA'].')" title="Eliminar "><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	
	public function setPersona(){
		if($_POST){
			
			if(empty($_POST['listTipoPersona']) || empty($_POST['txtNombre']) || empty($_POST['listgenero']) || empty($_POST['datefecha']) || empty($_POST['listTipoPersona']) 
			|| empty($_POST['txtIdentificacion'])|| empty($_POST['listStatus'])  )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{
				$idPersona = intval($_POST['idPersona']);
				$intCOD_TIPO_PERSONA = intval($_POST['listTipoPersona']);
					$strNOMBRE = strClean($_POST['txtNombre']);
					$intGENERO = intval($_POST['listgenero']);
					$intFECHA_NACIMIENTO = intval($_POST['datefecha']);
					$listTipoIdentificacion = intval($_POST['listTipoIdentificacion']);
					$txtIdentificacion = strClean($_POST['txtIdentificacion']);
					$intESTADO = intval($_POST['listStatus']);
					$request_persona = "";
				
					if($idPersona == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_persona = $this->model->insertPersona($intCOD_TIPO_PERSONA, 
																		$strNOMBRE, 
																		$intGENERO,
																		$intFECHA_NACIMIENTO, 
																		$listTipoIdentificacion,
																		$txtIdentificacion, 
																		$intESTADO );
						}
					}else{
						$option = 2;
							if($_SESSION['permisosMod']['u']){
								$request_persona = $this->model->updatePersona($idPersona,
								$intCOD_TIPO_PERSONA, 
								$strNOMBRE, 
								$enumGENERO,
								$dateFECHA_NACIMIENTO, 
								$listTipoIdentificacion,
								$txtIdentificacion, 
								$intESTADO );
						}
					}
					if($request_persona > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'COD_PERSONA' => $request_persona, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'COD_PERSONA' => $idPersona, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_persona == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe el Registro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();

	}

	// ---------------------------------------------EXTRAER PERSONAS EN COMPRAS---------------------------------------------
	public function getSelectPersonas(){
		$htmlOptions = "";
		$arrData = $this->model->selectPersonas();
		if(count($arrData) > 0){
			for ($i=0; $i < count($arrData); $i++){
				if($arrData[$i]['status'] == 1){
					$htmlOptions .= '<option value="'.$arrData[$i]['idpersona'].'">'.$arrData[$i]['nombre'].'</option>';
				}
			}
		}
		echo $htmlOptions;
		die();
	}
}
?>
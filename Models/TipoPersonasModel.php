<?php 

	class TipoPersonasModel extends Mysql
	{
		public $intIdTipo;

		public function __construct()
		{
			parent::__construct();
		}


		public function selectTipoPersonas(){
			$sql = "SELECT  idTipo,
							TIPO_PERSONA,
							status
				FROM tbl_tipo_persona WHERE status!=0 ";
				$request = $this->select_all($sql);
			return $request;
		}

		public function selectTipoPersona(int $idTipo){
			$this->intIdTipo = $idTipo;
			$sql = "SELECT * FROM tbl_tipo_persona
					WHERE idTipo = $this->intIdTipo";
			$request = $this->select($sql);
			return $request;
		}


	}
 ?>
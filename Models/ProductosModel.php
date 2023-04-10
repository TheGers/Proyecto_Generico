<?php

class ProductosModel extends Mysql
{
	private $intCOD_PRODUCTO;
	private $strNOMBRE_PRODUCTO;
	private $intCOD_CATEGORIA;
	private $strDESCRIPCION;
	private $intPRECIO;
	private $intEXISTENCIA;
	private $intESTADO;

	public function __construct()
	{
		parent::__construct();
	}

// --------------------------------------------------------------------------------------------------------------------------------------

	public function selectProductos(){
		$sql = "SELECT p.COD_PRODUCTO,
						p.NOMBRE_PRODUCTO,
						p.COD_CATEGORIA,
						c.NOMBRE as tbl_categoria,
						p.DESCRIPCION,
						p.PRECIO,
						p.EXISTENCIA,
						p.status 
				FROM tbl_producto p 
				INNER JOIN tbl_categoria c
				ON p.COD_CATEGORIA = c.idcategoria
				WHERE p.status != 0 ";
				$request = $this->select_all($sql);
		return $request;
	}
	// public function selectProductos()
	// 	{
	// 		$sql = "SELECT  COD_PRODUCTO,
	// 						NOMBRE_PRODUCTO,
	// 						DESCRIPCION,
	// 						status
	// 			FROM tbl_producto WHERE status!=0 ";
	// 			$request = $this->select_all($sql);
	// 		return $request;
	// 	}
	// ----------------------------------------------------------------------------------------------------------------------

	public function insertProducto(string $NOMBRE_PRODUCTO, int $COD_CATEGORIA,  string $DESCRIPCION, int $PRECIO, int $EXISTENCIA, int $status)
	{
		$this->strNOMBRE_PRODUCTO = $NOMBRE_PRODUCTO;
		$this->intCOD_CATEGORIA = $COD_CATEGORIA;
		$this->strDESCRIPCION = $DESCRIPCION;
		$this->intPRECIO = $PRECIO;
		$this->intEXISTENCIA = $EXISTENCIA;
		$this->intESTADO = $status;
		$return = 0;
		$sql = "SELECT * FROM tbl_producto WHERE NOMBRE_PRODUCTO = '{$this->strNOMBRE_PRODUCTO}'";
		$request = $this->select_all($sql);
		if (empty($request)) {
			$query_insert  = "INSERT INTO tbl_producto (NOMBRE_PRODUCTO,
														COD_CATEGORIA,
														DESCRIPCION,
														PRECIO,
														EXISTENCIA,
														status) 
								  VALUES(?,?,?,?,?,?)";
			$arrData = array(
				$this->strNOMBRE_PRODUCTO,
				$this->intCOD_CATEGORIA,
				$this->strDESCRIPCION,
				$this->intPRECIO,
				$this->intEXISTENCIA,
				$this->intESTADO
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}

	// ----------------------------------------------------------------------------------------------------------------------

	public function selectProducto(int $COD_PRODUCTO)
	{
		$this->intCOD_PRODUCTO = $COD_PRODUCTO;
		$sql = "SELECT p.COD_PRODUCTO,
							p.NOMBRE_PRODUCTO,
							p.COD_CATEGORIA,
							c.NOMBRE as tbl_categoria,
							p.DESCRIPCION,
							p.PRECIO,
							p.EXISTENCIA,
							p.status
					FROM tbl_producto p
					INNER JOIN tbl_categoria c
					ON p.COD_CATEGORIA = c.idcategoria
					WHERE COD_PRODUCTO = $this->intCOD_PRODUCTO";
		$request = $this->select($sql);
		return $request;
	}

	public function updateProducto(
		int $COD_PRODUCTO,
		string $NOMBRE_PRODUCTO,
		int $COD_CATEGORIA,
		string $DESCRIPCION,
		int $PRECIO,
		int $EXISTENCIA,
		int $status
	) {
		$this->intCOD_PRODUCTO = $COD_PRODUCTO;
		$this->strNOMBRE_PRODUCTO = $NOMBRE_PRODUCTO;
		$this->intCOD_CATEGORIA = $COD_CATEGORIA;
		$this->strDESCRIPCION = $DESCRIPCION;
		$this->intPRECIO = $PRECIO;
		$this->intEXISTENCIA = $EXISTENCIA;
		$this->intESTADO = $status;
		$return = 0;
		$sql = "SELECT * FROM tbl_producto WHERE NOMBRE_PRODUCTO = '{$this->strNOMBRE_PRODUCTO}' AND 
			COD_PRODUCTO != $this->intCOD_PRODUCTO ";
		$request = $this->select_all($sql);
		if (empty($request)) {
			$sql = "UPDATE tbl_producto 
						SET NOMBRE_PRODUCTO=?,
						COD_CATEGORIA=?,
						DESCRIPCION=?,
						PRECIO=?,
						EXISTENCIA=?,
							status=? 
						WHERE COD_PRODUCTO = $this->intCOD_PRODUCTO ";
			$arrData = array(
				$this->strNOMBRE_PRODUCTO,
				$this->intCOD_CATEGORIA,
				$this->strNombre,
				$this->strDescripcion,
				$this->strDESCRIPCION,
				$this->intPRECIO,
				$this->intESTADO
			);

			$request = $this->update($sql, $arrData);
			$return = $request;
		} else {
			$return = "exist";
		}
		return $return;
	}

	// ----------------------------------------------------------------------------------------------------------------------

	public function deleteProducto(int $COD_PRODUCTO)
	{
		$this->intCOD_PRODUCTO = $COD_PRODUCTO;
		$sql = "UPDATE tbl_producto SET status = ? WHERE COD_PRODUCTO = $this->intCOD_PRODUCTO ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}

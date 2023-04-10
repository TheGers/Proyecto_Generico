<?php

class ComprasModel extends Mysql
{

    private $intCOD_COMPRA;
    private $intCOD_PERSONA;
    private $strCAI;
    private $strNUMERO_FACTURA;
    private $strDESCRIPCION;
    private $intSUBTOTAL;
    private $intIMPUESTO;
    private $intDESCUENTO;
    private $intTOTAL;
    private $intstatus;
    private $FECHA_CREACION;

    public function __construct()
    {
        parent::__construct();
    }


    // -----------------------------------------------------------------------------------------------------------------------------
    public function selectCompras()
    {
        $sql = "SELECT c.COD_COMPRA,
             c.COD_PERSONA,
             p.NOMBRE as tbl_personas,
            c.CAI,
            c.NUMERO_FACTURA,
            c.DESCRIPCION,
            c.SUBTOTAL,
            c.IMPUESTO,
            c.DESCUENTO,
            c.TOTAL,
            c.status 
    FROM tbl_compras c 
    INNER JOIN tbl_personas p
    ON c.COD_PERSONA = p.COD_PERSONA
    WHERE c.status != 0 ";
        $request = $this->select_all($sql);
        return $request;
    }


    // -----------------------------------------------------------------------------------------------------------------------------

    public function insertCompras(
        int $intCOD_COMPRA,
        int $COD_PERSONA,
        string $CAI,
        string $NUMERO_FACTURA,
        string $DESCRIPCION,
        int $SUBTOTAL,
        int $IMPUESTO,
        int $DESCUENTO,
        int $TOTAL,
        int $status
    ) {
        $return = 0;
        $this->intCOD_COMPRA = $intCOD_COMPRA;
        $this->intCOD_PERSONA = $COD_PERSONA;
        $this->strCAI = $CAI;
        $this->strNUMERO_FACTURA = $NUMERO_FACTURA;
        $this->strDESCRIPCION = $DESCRIPCION;
        $this->intSUBTOTAL = $SUBTOTAL;
        $this->intIMPUESTO = $IMPUESTO;
        $this->intDESCUENTO = $DESCUENTO;
        $this->intTOTAL = $TOTAL;
        $this->intstatus = $status;

        $sql = "SELECT * FROM tbl_compras WHERE COD_COMPRA = '{$this->intCOD_COMPRA}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert  = "INSERT INTO tbl_compras (COD_COMPRA,
                                                       COD_PERSONA,
														CAI,
                                                        NUMERO_FACTURA,
														DESCRIPCION,
														SUBTOTAL,
														IMPUESTO,
                                                        DESCUENTO,
                                                        TOTAL,
														status) 
								  VALUES(?,?,?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->intCOD_COMPRA,
                $this->intCOD_PERSONA,
                $this->strCAI,
                $this->strNUMERO_FACTURA,
                $this->strDESCRIPCION,
                $this->intSUBTOTAL,
                $this->intIMPUESTO,
                $this->intDESCUENTO,
                $this->intTOTAL,
                $this->intstatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }


    // -----------------------------------------------------------------------------------------------------------------------------
    public function selectCompra(int $intCOD_COMPRA)
    {
        $sql = "SELECT c.COD_COMPRA,
             c.COD_PERSONA,
             p.NOMBRE as tbl_personas,
            c.CAI,
            c.NUMERO_FACTURA,
            c.DESCRIPCION,
            c.SUBTOTAL,
            c.IMPUESTO,
            c.DESCUENTO,
            c.TOTAL,
            c.status 
    FROM tbl_compras c 
    INNER JOIN tbl_personas p
    ON c.COD_PERSONA = p.COD_PERSONA
    WHERE COD_COMPRA = $this->intCOD_COMPRA";
        $request = $this->select($sql);
        return $request;
    }




}

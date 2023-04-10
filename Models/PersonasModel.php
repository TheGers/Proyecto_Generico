<?php

class PersonasModel extends Mysql
{


    private $intCOD_PERSONA;
    private $intCOD_TIPO_PERSONA;
    private $strNOMBRE;
    private $intGENERO;
    private $intFECHA_NACIMIENTO;
    private $intCOD_TIPO_IDENTIFICACION;
    private $intIDENTIFICACION;
    private $intCOD_DIRECCION;
    private $intCOD_TELEFONO;
    private $intESTADO;

    public function __construct()
    {
        parent::__construct();
    }

    // ----------------------- CONECTADO AL CONTROLADOR PARA MOSTRAR ----------------------------------
    public function selectPersonas()
    {
        $sql = "SELECT * FROM tbl_personas
        WHERE status !=0 ";
        $request = $this->select_all($sql);
        return $request;
    }
    // -------------------------------------------------------------------------------------------------

    public function insertPersona(
        int $COD_TIPO_PERSONA,
        string $NOMBRE,
        int $GENERO,
        int $FECHA_NACIMIENTO,
        int $COD_TIPO_IDENTIFICACION,
        int $IDENTIFICACION,
        int $status
    ) {
        $this->intCOD_TIPO_PERSONA = $COD_TIPO_PERSONA;
        $this->strNOMBRE = $NOMBRE;
        $this->intGENERO = $GENERO;
        $this->intFECHA_NACIMIENTO = $FECHA_NACIMIENTO;
        $this->intCOD_TIPO_IDENTIFICACION = $COD_TIPO_IDENTIFICACION;
        $this->intIDENTIFICACION = $IDENTIFICACION;
        $this->intESTADO = $status;
        $return = 0;
        $sql = "SELECT * FROM tbl_personas WHERE NOMBRE = '{$this->strNOMBRE}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert  = "INSERT INTO tbl_personas (COD_TIPO_PERSONA,
														NOMBRE,
														GENERO,
														FECHA_NACIMIENTO,
														COD_TIPO_IDENTIFICACION,
                                                        IDENTIFICACION,
														status) 
								  VALUES(?,?,?,?,?,?,?)";
            $arrData = array(
                $this->intCOD_TIPO_PERSONA,
                $this->strNOMBRE,
                $this->intGENERO,
                $this->intFECHA_NACIMIENTO,
                $this->intCOD_TIPO_IDENTIFICACION,
                $this->intIDENTIFICACION,
                $this->intESTADO
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
}

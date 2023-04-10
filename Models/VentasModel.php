<?php 

	class VentasModel extends Mysql
	{
       
  
        private $intCOD_COMPRA;
        private $intCOD_PERSONA;
        private $intCAI;
        private $intNUMERO_FACTURA;
        private $intDESCRIPCION;
        private $intSUBTOTAL;
        private $intIMPUESTO;
        private $intDESCUENTO;
        private $intTOTAL;
        private $intESTADO;
    
        public function __construct(){
            parent::__construct();
        }
    
        public function selectVentas(){
            $sql = "SELECT c.COD_VENTA,
             c.COD_PERSONA,
             p.NOMBRE as tbl_personas,
            c.COD_TIPO_MOVIMIENTO,
            m.TIPO_MOVIMIENTO as tbl_tipo_movimiento,
            c.DESCRIPCION,
            c.SUBTOTAL,
            c.IMPUESTO,
            c.DESCUENTO,
            c.COD_TIPO_PAGO,
            g.TIPO_PAGO as tbl_tipo_pago,
            c.NUMERO_COMPROBANTE,
            c.status 
    FROM tbl_ventas c 
    INNER JOIN tbl_personas p
    ON c.COD_PERSONA = p.COD_PERSONA
    INNER JOIN tbl_tipo_movimiento m
    ON c.COD_TIPO_MOVIMIENTO = m.id
    INNER JOIN tbl_tipo_pago g
    ON c.COD_TIPO_PAGO = g.id
    WHERE c.status != 0 ";
    $request = $this->select_all($sql);
return $request;
		}
    
      

	
	}
 ?>
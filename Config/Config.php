<?php 
	
	//define("BASE_URL", "http://localhost/tienda_virtual/");
	const BASE_URL = "http://localhost/Gerson";

	//Zona horaria
	//date_default_timezone_set('America/Guatemala');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "gerson";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8";
// Intentar conectarse a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  
// Comprobar si la conexión fue exitosa

if(!$conexion){

	echo 'Conexion Fallida';
}
	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "Lps.";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "Tienda Virtual";
	const EMAIL_REMITENTE = "no-reply@abelosh.com";
	const NOMBRE_EMPESA = "Tienda Virtual";
	const WEB_EMPRESA = "www.abelosh.com";
	



	


 ?>
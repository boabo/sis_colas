<?php
include_once(dirname(__FILE__).'/../../lib/rest/PxpRestClient.php');
include(dirname(__FILE__).'/../../lib/DatosGenerales.php');

include_once(dirname(__FILE__).'/../../lib/lib_general/ExcelInput.php');

//Generamos el documento con REST
$pxpRestClient = PxpRestClient::connect('127.0.0.1',substr($_SESSION["_FOLDER"], 1) .'pxp/lib/rest/')
    ->setCredentialsPxp($_GET['user'],$_GET['pw']);


$datos_bd = $pxpRestClient->doPost('colas/SucursalServicio/resetFichaSucursalServicio',
    array(	"id_sucursal_servicio"=>0));

$resp_datos = json_decode($datos_bd);



//si existe error al traer los archivos existentes que ya se registaron entonces exit
if($resp_datos->ROOT->error == true){
    echo "error al traer datos del erp";
    exit;
}
var_dump($resp_datos);





?>
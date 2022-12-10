<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/ordenes.php';
// inicializar base de datos y objeto actividad
$conex = new Conexion();
$db = $conex->obtenerConexion();
// inicializar objeto
$orden = new Ordenes($db);
$data = json_decode(file_get_contents("php://input"));
$orden->id = isset($data->id) ? $data->id : die();

if($orden->eliminar_orden()){
    // asignar codigo de respuesta
    http_response_code(200);
    // informar al usuario
    echo json_encode(array("message" => "La orden ha sido eliminada."));
}
else{
    // asignar codigo de respuesta - 503 servicio no disponible
    http_response_code(503);
    // informar al usuario
    echo json_encode(array("message" => "No se puede eliminar la orden."));
}
?>
<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/productos.php';
// inicializar base de datos y objeto actividad
$conex = new Conexion();
$db = $conex->obtenerConexion();
// inicializar objeto
$producto = new Productos($db);
$data = json_decode(file_get_contents("php://input"));
$producto->id = isset($data->id) ? $data->id : die();

if($producto->eliminar_producto()){
    // asignar codigo de respuesta
    http_response_code(200);
    // informar al usuario
    echo json_encode(array("message" => "El producto ha sido eliminado."));
}
else{
    // asignar codigo de respuesta - 503 servicio no disponible
    http_response_code(200);
    // informar al usuario
    echo json_encode(array("message" => "No se puede eliminar el producto."));
}
?>
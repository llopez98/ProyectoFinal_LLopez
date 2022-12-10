<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/usuarios.php';
// inicializar base de datos y objeto actividad
$conex = new Conexion();
$db = $conex->obtenerConexion();
// inicializar objeto
$usuario = new Usuarios($db);
$data = json_decode(file_get_contents("php://input"));
$usuario->id = isset($data->id) ? $data->id : die();

if($usuario->eliminar_usuario()){
    // asignar codigo de respuesta
    http_response_code(200);
    // informar al usuario
    echo json_encode(array("message" => "El usuario ha sido eliminada."));
}
else{
    // asignar codigo de respuesta - 503 servicio no disponible
    http_response_code(503);
    // informar al usuario
    echo json_encode(array("message" => "No se puede eliminar el usuario."));
}
?>
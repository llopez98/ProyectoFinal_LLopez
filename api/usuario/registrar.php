<?php
    // encabezados obligatorios
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");

    include_once '../configuracion/conexion.php';
    include_once '../objetos/usuarios.php';
    $conex = new Conexion();
    $db = $conex->obtenerConexion();
    $usuario = new Usuarios($db);
    // obtener los datos
    $data = json_decode(file_get_contents("php://input"));
    // asegurar que los datos no esten vacios
    if(
    !empty($data->nombre) &&
    !empty($data->contrasena) &&
    !empty($data->tipo)
    ){
        $usuario->nombre = $data->nombre;
        $usuario->contrasena = $data->contrasena;
        $usuario->tipo = $data->tipo;

        if($usuario->registrar_usuario()){
            // asignar codigo de respuesta - 201 creado
            http_response_code(201);
            // informar al usuario
            echo json_encode(array("message" => "El usuario ha sido creado."));
        }
        else{
            // asignar codigo de respuesta - 503 servicio no disponible
            http_response_code(503);
            // informar al usuario
            echo json_encode(array("message" => "No se puede crear el usuario."));
        }
    }
    // informar al usuario que los datos estan incompletos
    else{
        // asignar codigo de respuesta - 400 solicitud incorrecta
        http_response_code(400);
        // informar al usuario
        echo json_encode(array("message" => "No se puede crear el usuario. Los datos
    están incompletos."));
    }
?>
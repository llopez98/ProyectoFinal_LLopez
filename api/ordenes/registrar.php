<?php
    // encabezados obligatorios
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: *");

    include_once '../configuracion/conexion.php';
    include_once '../objetos/ordenes.php';
    $conex = new Conexion();
    $db = $conex->obtenerConexion();
    $orden = new Ordenes($db);
    // obtener los datos
    $data = json_decode(file_get_contents("php://input"));
    // asegurar que los datos no esten vacios
    if(
    !empty($data->id_producto) &&
    !empty($data->cliente) &&
    !empty($data->cantidad)&&
    !empty($data->precio)&&
    !empty($data->itbms)&&
    !empty($data->precio_total)
    ){
        $orden->id_producto = $data->id_producto;
        $orden->cliente = $data->cliente;
        $orden->cantidad = $data->cantidad;
        $orden->precio = $data->precio;
        $orden->itbms = $data->itbms;
        $orden->precio_total = $data->precio_total;

        if($orden->registrar_orden()){
            // asignar codigo de respuesta - 201 creado
            http_response_code(201);
            // informar al usuario
            echo json_encode(array("message" => "La orden ha sido creada."));
        }
        else{
            // asignar codigo de respuesta - 503 servicio no disponible
            http_response_code(503);
            // informar al usuario
            echo json_encode(array("message" => "No se puede crear la orden."));
        }
    }
    // informar al usuario que los datos estan incompletos
    else{
        // asignar codigo de respuesta - 400 solicitud incorrecta
        http_response_code(400);
        // informar al usuario
        echo json_encode(array("message" => "No se puede crear la orden. Los datos
    están incompletos."));
    }
?>
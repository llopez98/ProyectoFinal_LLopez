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
    !empty($data->id)
    ){
        $orden->id = $data->id;

        $stmt = $orden->leer_orden();
        $num = $stmt->rowCount();
        // arreglo de actividades
        $orden_arr = array();
        $orden_arr["records"] = array();
        // obtiene todo el contenido de la tabla
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extraer fila
            // esto creara de $row['nombre'] a
            // solamente $nombre
            extract($row);
            $item = array(
                "id" => $id,
                "nombre" => $nombre,
                "cliente" => $cliente,
                "cantidad" => $cantidad,
                "precio" => $precio,
                "itbms" => $itbms,
                "precio_total" => $precio_total
            );
            array_push($orden_arr["records"], $item);
        }
        // asignar codigo de respuesta - 200 OK
        http_response_code(200);
        // mostrar productos en formato json
        echo json_encode($orden_arr);
    }
?>
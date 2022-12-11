<?php
    // encabezados obligatorios
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");

    include_once '../configuracion/conexion.php';
    include_once '../objetos/productos.php';
    $conex = new Conexion();
    $db = $conex->obtenerConexion();
    $producto = new Productos($db);
    // obtener los datos

        $stmt = $producto->leer_productos();
        $num = $stmt->rowCount();
        // arreglo de actividades
        $productos_arr = array();
        $productos_arr["records"] = array();
        // obtiene todo el contenido de la tabla
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extraer fila
            // esto creara de $row['nombre'] a
            // solamente $nombre
            extract($row);
            $item = array(
                "id" => $id,
                "nombre" => $nombre,
                "numero_producto" => $numero_producto,
                "color" => $color,
                "precio_unitario" => $precio_unitario,
                "cantidad_inventario" => $cantidad_inventario,
            );
            array_push($productos_arr["records"], $item);
        }
        // asignar codigo de respuesta - 200 OK
        http_response_code(200);
        // mostrar productos en formato json
        echo json_encode($productos_arr);
?>
<?php
class Productos
{
	// conexion de base de datos
	private $conn;

	// atributos de la clase
	public $id;
	public $nombre;
	public $numero_producto;
	public $color;
	public $precio_unitario;
    public $cantidad_inventario;

	// constructor con $db como conexion a base de datos
	public function __construct($db)
	{
		$this->conn = $db;
	}

	function registrar_producto()
	{
		// query para seleccionar todos
		$query = "CALL sp_registrar_producto(?,?,?,?,?)";
		$stmt = $this->conn->prepare($query);
		
		// bind values
		$stmt->bindParam(1, $this->nombre);
		$stmt->bindParam(2, $this->numero_producto);
		$stmt->bindParam(3, $this->color);
        $stmt->bindParam(4, $this->precio_unitario);
		$stmt->bindParam(5, $this->cantidad_inventario);

		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function actualizar_producto(){
		$query = "CALL sp_actualizar_producto(?,?,?,?,?,?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->nombre);
        $stmt->bindParam(3, $this->numero_producto);
		$stmt->bindParam(4, $this->color);
        $stmt->bindParam(5, $this->precio_unitario);
		$stmt->bindParam(6, $this->cantidad_inventario);
		$stmt->execute();
		return $stmt;
	}

	function eliminar_producto(){
		$query = "CALL sp_eliminar_producto(?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		
		if($stmt->execute()){
			return true;
		}
		return false;
	}

	function leer_productos(){
		$query = "CALL sp_listar_productos()";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
}
?>

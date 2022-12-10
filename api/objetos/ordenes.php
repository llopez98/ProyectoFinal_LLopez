<?php
class Ordenes
{
	// conexion de base de datos
	private $conn;

	// atributos de la clase
	public $id;
	public $id_producto;
	public $cliente;
	public $cantidad;
	public $precio;
    public $itbms;
    public $precio_total;

	// constructor con $db como conexion a base de datos
	public function __construct($db)
	{
		$this->conn = $db;
	}

	function registrar_orden()
	{
		// query para seleccionar todos
		$query = "CALL sp_registrar_orden(?,?,?,?,?,?)";
		$stmt = $this->conn->prepare($query);
		
		// bind values
		$stmt->bindParam(1, $this->id_producto);
		$stmt->bindParam(2, $this->cliente);
		$stmt->bindParam(3, $this->cantidad);
        $stmt->bindParam(4, $this->precio);
		$stmt->bindParam(5, $this->itbms);
        $stmt->bindParam(6, $this->precio_total);

		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function actualizar_orden(){
		$query = "CALL sp_actualizar_orden(?,?,?,?,?,?,?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->id_producto);
		$stmt->bindParam(3, $this->cliente);
		$stmt->bindParam(4, $this->cantidad);
        $stmt->bindParam(5, $this->precio);
		$stmt->bindParam(6, $this->itbms);
        $stmt->bindParam(7, $this->precio_total);
		$stmt->execute();
		return $stmt;
	}

	function eliminar_orden(){
		$query = "CALL sp_eliminar_orden(?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		
		if($stmt->execute()){
			return true;
		}
		return false;
	}

    function leer_ordenes(){
        $query = "CALL sp_listar_ordenes()";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
    }

	function leer_orden(){
		$query = "CALL sp_listar_orden(?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
		return $stmt;
	}
}
?>

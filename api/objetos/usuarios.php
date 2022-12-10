<?php
class Usuarios
{
	// conexion de base de datos
	private $conn;

	// atributos de la clase
	public $id;
	public $nombre;
	public $contrasena;
	public $tipo;
	public $ultima_sesion;

	// constructor con $db como conexion a base de datos
	public function __construct($db)
	{
		$this->conn = $db;
	}

	function registrar_usuario()
	{
		// query para seleccionar todos
		$query = "CALL sp_registrar_usuario(?,?,?)";
		$stmt = $this->conn->prepare($query);
		
		// bind values
		$stmt->bindParam(1, $this->nombre);
		$stmt->bindParam(2, $this->contrasena);
		$stmt->bindParam(3, $this->tipo);

		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function loguear_usuario(){
		$query = "CALL sp_loguear_usuario(?, ?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->nombre);
		$stmt->bindParam(2, $this->contrasena);
		$stmt->execute();
		return $stmt;
	}

	function eliminar_usuario(){
		$query = "CALL sp_eliminar_usuario(?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		
		if($stmt->execute()){
			return true;
		}
		return false;
	}
}
?>

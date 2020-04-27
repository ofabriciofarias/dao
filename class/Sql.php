<?php
//Classe de gerencia da comunicação
class Sql extends PDO{

	private $conn;

	//Método construtor para conectar ao banco
	public function __construct(){
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7","root","root");
	}

	//Para vários parametros
	private function setParams($statement, $parameters = array()){
		//Atualizo tudo dentro do foreach pelo bindParams
		foreach ($parameters as $key => $value) {
			$this->setParam($statement, $key, $value);
			//$statement->bindParam($key, $value);
		}
	}

	//Para um parametro
	private function setParam($statement, $key, $value){
		$statement->bindParam($key, $value);
	}

	//Método para comunicação
	public function query($rawQuery, $params = array()){
		$stmt = $this->conn->prepare($rawQuery);
		
		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;
	}

	//Método para o select
	public function select($rawQuery, $params = array()):array 
	{
		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}
}

?>
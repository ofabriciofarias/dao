<?php
//Classe Usuário

class Usuario{

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	//encapsulamento idusuario
	public function getIdUsuario(){
		return $this->idusuario;
	}

	public function setIdUsuario($idusuario){
		$this->idusuario = $idusuario;
	}

	//encapsulamento deslogin
	public function getDesLogin(){
		return $this->deslogin;
	}

	public function setDesLogin($deslogin){
		$this->deslogin = $deslogin;
	}


	//encapsulamento dessenha
	public function getDesSenha(){
		return $this->dessenha;
	}

	public function setDesSenha($dessenha){
		$this->dessenha = $dessenha;
	}

	//encapsulamento dtcadastro
	public function getDtCadastro(){
		return $this->dtcadastro;
	}

	public function setDtCadastro($dtcadastro){
		$this->dtcadastro = $dtcadastro;
	}


	//Método carregar informações pelo ID
	public function loadById($id){
		$sql = new Sql();

		$resultado = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = :ID", array(
			":ID"=>$id));

		//isset verifica se existe
		//Poderia fazer pelo count também: if(count($resultado) > 0){}
		if(isset($resultado[0])){
		//if(count($resultado) > 0){
			//Crio uma linha para receber os dados da primeira linha.
			$row = $resultado[0];
			$this->setIdUsuario($row['idusuario']);
			$this->setDesLogin($row['deslogin']);
			$this->setDesSenha($row['dessenha']);
			//new DateTime() para já converter para o formato.
			$this->setDtCadastro(new DateTime($row['dtcadastro']));
		}
	}

	//__toString para usar o echo e mostrar as informações com o json
	public function __toString(){
		return json_encode(array(
			"idusuario"=>$this->getIdUsuario(),
			"deslogin"=>$this->getDesLogin(),
			"dessenha"=>$this->getDesSenha(),
			"dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
		));
	}
}


?>
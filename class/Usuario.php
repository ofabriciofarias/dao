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
			$this->setData($resultado[0]);
			/*
			//Crio uma linha para receber os dados da primeira linha.
			$row = $resultado[0];
			$this->setIdUsuario($row['idusuario']);
			$this->setDesLogin($row['deslogin']);
			$this->setDesSenha($row['dessenha']);
			//new DateTime() para já converter para o formato.
			$this->setDtCadastro(new DateTime($row['dtcadastro'])); */
		}
	}

	//Retonar uma lista de usuários
	public function getList(){
		$sql = new Sql();
		//echo "Estou aqui";
		return $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin;");
	}

	//Busca Usuário pelo Nome utilizando um método static e sua aplicação no index.php
	public static function buscaUsuarioPeloNome($login){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login));
	}

	//Busca Usuários com nomes parecidos
	public static function buscaUsuarios($login){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :BUSCA ORDER BY deslogin", array(
			":BUSCA"=>"%" . $login . "%"
		));
	}

	//Criando um método login
	public function login($login, $senha){

		$sql = new Sql();

		$resultado = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :LOGIN AND dessenha = :SENHA", array(
			":LOGIN"=>$login,
			":SENHA"=>$senha
		));

		if(count($resultado) > 0){
			
			$this->setData($resultado[0]);
			/*
			$row = $resultado[0];

			$this->setIdUsuario($row['idusuario']);
			$this->setDesLogin($row['deslogin']);
			$this->setDesSenha($row['dessenha']);
			$this->setDtCadastro(new DateTime($row['dtcadastro'])); 
			*/
		}else{
			throw new Exception("Login e/ou senha inválido");
			//echo "Usuário ou Senha Inválido<br>";
		}

	}

	//Adiciona dados
	public function setData($data){

		$this->setIdUsuario($data['idusuario']);
		$this->setDesLogin($data['deslogin']);
		$this->setDesSenha($data['dessenha']);
		$this->setDtCadastro(new DateTime($data['dtcadastro']));

	}

	//Inserção no banco de dados usando storage procedures
	public function insert(){
		$sql = new Sql();
		//storage procedures (sp)
		//Verifica o id gerado na tabela e retorna
		$resultado = $sql->select("CALL sp_usuarios_insert(:LOGIN, :SENHA)", array(
			":LOGIN"=>$this->getDesLogin(),
			":SENHA"=>$this->getDesSenha()
		));

		if(count($resultado) > 0){
			$this->setData($resultado[0]);
		}
	} 

	//Apagar as informações do banco de dados
	public function delete(){
		$sql = new Sql();
		//deletando a linha e não usa o *
		$sql->query("DELETE FROM tb_usuario WHERE idusuario = :ID", array(
			':ID'=>$this->getIdUsuario()
		));

		//Para zerar as informações do objeto
		$this->setIdUsuario(0);
		$this->setDesLogin("");
		$this->setDesSenha("");
		$this->setDtCadastro(new DateTime());
	}


	//Atualização de informação no banco.
	public function update($login, $senha){
		$sql = new Sql();

		$this->setDesLogin($login);
		$this->setDesSenha($senha);

		$sql->query("UPDATE tb_usuario SET deslogin = :LOGIN, dessenha = :SENHA WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDesLogin(),
			':SENHA'=>$this->getDesSenha(),
			':ID'=>$this->getIdUsuario()
		));
	}
	//Construtor
	// = "" para não ser obrigarório
	public function __construct($login = "", $senha = ""){
		$this->setDesLogin($login);
		$this->setDesSenha($senha);
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
<?php

require_once("config.php");

$sql = new Sql();


$usuarios = $sql->select("SELECT * FROM tb_usuario");

echo json_encode($usuarios);

echo "<br><br><br><br><br>==============Trazendo as informações de um Usuário ID 3 =======================<br><br>";

$usuario = new Usuario();

$usuario->loadById(3);

echo $usuario;

echo "<br><br><br><br><br>==============Trazendo as informações de uma Lista de Usuários =======================<br><br>";

$listaUsuario = new Usuario();

echo json_encode($listaUsuario->getList());

/*
Outra opção seria criar o método como static e chamr diretamente aqui
ficaria aqui $listaUsuario = Usuario::getList();
Depois utilizaria o echo json_encode($lista); para apresentar.

Lá na classe Usuário teríamos o nome do método como public static function getList(){}
*/

echo "<br><br><br><br><br>==============Buscando uma lista de Usuários que contém exatamente o mesmo Login, Utilizando neste caso uma função static =======================<br><br>";

$busca = Usuario::buscaUsuarioPeloNome("usuario01");

echo json_encode($busca);

echo "<br><br><br><br><br>==============Buscando uma lista de Usuários Buscando por Login Parecidos, Utilizando neste caso uma função static =======================<br><br>";
$buscaParecidos = Usuario::buscaUsuarios("roo");

echo json_encode($buscaParecidos);

echo "<br><br><br><br><br>==============Carregando Usuário Usando Login e Senha =======================<br><br>";

$novoUsuario = new Usuario();
$novoUsuario->login("usuario01","12345");

echo $novoUsuario;

?>
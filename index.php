<?php

require_once("config.php");

$sql = new Sql();


$usuarios = $sql->select("SELECT * FROM tb_usuario");

echo json_encode($usuarios);

echo "<br><br><br><br><br>==============Trazendo as informações do ID 3 =======================<br><br>";

$usuario = new Usuario();

$usuario->loadById(3);

echo $usuario;
?>
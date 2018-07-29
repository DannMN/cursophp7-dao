<?php
    require_once('config.php');

/*
$sql = new Sql();
$usuarios = $sql->select("SELECT * FROM tb_usuario");
echo json_encode($usuarios);


$root = new Usuario();
$root2 = new Usuario();
O loadbyid carrega um usuario
$root2->loadById(3);
$root->loadById(7);

echo $root;
*/

//$lista = Usuario::getList();

//echo json_encode($lista);

//Carrega uma lista de usuarios buscando pelo login
//$search = Usuario::search("e");
//echo json_encode($search);

//carrega um usuario usando o login e a senha

$usuario = new Usuario();

$usuario->login("daniel","102030");

echo $usuario;
?>
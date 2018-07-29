<?php
    require_once('config.php');

/*
$sql = new Sql();

$usuarios = $sql->select("SELECT * FROM tb_usuario");

echo json_encode($usuarios);
*/

$root = new Usuario();
$root2 = new Usuario();

$root2->loadById(3);
$root->loadById(7);

echo $root;


?>
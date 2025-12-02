<?php
session_start();
require "db.php";

$nome = $_POST['nome'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$nome || !$senha) {
    echo "ERRO";
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $sql = $db->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
    $sql->execute([$nome, $senhaHash]);

    echo "OK";
} catch (Exception $e) {
    echo "EXISTE"; // nome já cadastrado
}
?>
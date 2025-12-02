<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];

    if (!$nome || !$senha) {
        die("Preencha todos os campos!");
    }

    // Verifica se o usuário existe
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE nome = :nome LIMIT 1");
    $stmt->bindParam(':nome', $nome);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['nome'];
        header("Location: ../index.html"); // Redireciona para a página principal
        exit;
    } else {
        die("Nome ou senha incorretos!");
    }
} else {
    die("Acesso inválido.");
}
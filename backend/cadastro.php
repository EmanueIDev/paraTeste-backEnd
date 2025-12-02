<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if (!$nome || !$senha || !$confirmar) {
        die("Preencha todos os campos!");
    }

    if ($senha !== $confirmar) {
        die("As senhas não coincidem!");
    }

    // Criptografa a senha
    $hashSenha = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO usuarios (nome, senha) VALUES (:nome, :senha)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':senha', $hashSenha);
        $stmt->execute();

        $_SESSION['usuario'] = $nome;
        header("Location: ../index.html"); // Redireciona para a página principal
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            die("Usuário já existe!");
        } else {
            die("Erro: " . $e->getMessage());
        }
    }
} else {
    die("Acesso inválido.");
}
?>
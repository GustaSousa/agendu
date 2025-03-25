<?php
session_start(); // Inicia a sessão antes de qualquer saída

// Se o usuário já estiver logado, redireciona para o dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: /src/views/dashboard.php");
    exit(); // Importante: finaliza o script após o redirecionamento
}

require_once(__DIR__ . '/../src/config/config.php'); // Inclui apenas depois da verificação
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendu - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Agendu</h1>
    <ul class="index">
        <a href="/src/views/login.php">Login</a>
        <a href="/src/views/register.php">Registrar Novo Usuário</a>
    </ul>
</body>
</html>
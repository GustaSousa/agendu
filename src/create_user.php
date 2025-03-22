<?php
require 'config.php';

$username = "Duda";
$email = "duda@agendu.com";
$password_hash = password_hash("Duda3426&", PASSWORD_DEFAULT); // Hash da senha
$departament = "Amor da minha vida";
$is_admin = 1;

$stmt = $pdo->prepare("INSERT INTO users (nome, email, senha, cargo) VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $email, $senha, $cargo]);

echo "Usuário administrador criado com sucesso!";

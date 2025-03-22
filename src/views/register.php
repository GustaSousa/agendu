<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $department = trim($_POST["department"]);
    $is_admin = isset($_POST["is_admin"]) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, email, password_hash, department, is_admin) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $department, $is_admin]);
        echo "Usuário cadastrado com sucesso!";
    } catch (Exception $e) {
        die("Erro ao cadastrar usuário: " . $e->getMessage());
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Senha" required>
    <input type="text" name="department" placeholder="Setor" required>
    <label><input type="checkbox" name="is_admin"> Admin?</label>
    <button type="submit">Cadastrar</button>
</form>
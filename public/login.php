<?php
session_start();
require '../src/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user["senha"])) {
        $_SESSION["user"] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Credenciais inválidas.";
    }
}
?>

<form method="POST">
    Email: <input type="email" name="email" required>
    Senha: <input type="password" name="senha" required>
    <button type="submit">Entrar</button>
</form>
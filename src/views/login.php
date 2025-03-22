<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    try {
        // Permite login tanto com email quanto com username
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? OR username = ?");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password_hash"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["is_admin"] = $user["is_admin"];
            echo "Login bem-sucedido! <a href='schedule.php'>Ir para Agendamentos</a>";
        } else {
            echo "Usuário ou senha inválidos!";
        }
    } catch (Exception $e) {
        die("Erro no login: " . $e->getMessage());
    }
}
?>

<form method="POST">
    <input type="text" name="login" placeholder="Email ou Username" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
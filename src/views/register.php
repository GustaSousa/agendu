<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Se o usuário estiver logado e for administrador, o campo "is_admin" será visível
$is_admin_allowed = isset($_SESSION["user_id"]) && $_SESSION["is_admin"] == 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $department = trim($_POST["department"]);

    // Se o usuário não for admin, força o campo is_admin a ser 0 (falso)
    $is_admin = ($is_admin_allowed && isset($_POST["is_admin"])) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, email, password_hash, department, is_admin) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $department, $is_admin]);
        echo "Usuário cadastrado com sucesso!";
        echo "<script>
            window.alert('Usuário cadastrado com sucesso!');
            setTimeout(function() {
                window.location.href = 'dashboard.php';
            }, 0);
        </script>";
    } catch (Exception $e) {
        // die("Erro ao cadastrar usuário: " . $e->getMessage());
        //cria alert e envia usuario para o registrar novamente
        echo "<script>
            window.alert('Erro ao cadastrar usuário!');
            setTimeout(function() {
                window.location.href = 'register.php';
            }, 0);
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="/public/assets/css/forms.css">
</head>

<body>
    <div class="voltar">
        <a href="/public/index.php">Voltar</a>
    </div>

    <h1>
        Novo Usuário
    </h1>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <input type="text" name="department" placeholder="Setor" required>

        <?php if ($is_admin_allowed): ?>
            <label class="checkbox-label">
                <input type="checkbox" name="is_admin"> 
                <span>Administrador</span>
            </label>
        <?php else: ?>
            <input type="hidden" name="is_admin" value="0">
        <?php endif; ?>

        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>
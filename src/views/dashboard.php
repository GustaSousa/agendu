<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. Faça <a href='login.php'>login</a>.");
}

$username = $_SESSION["username"];
$is_admin = $_SESSION["is_admin"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($username); ?>!</h1>

    <ul>
        <!-- Links para funcionalidades disponíveis -->
        <li><a href="schedule.php">Agendar Evento</a></li>

        <?php if ($is_admin): ?>
            <li><a href="users_list.php">Gerenciar Usuários</a></li>
        <?php endif; ?>

        <li><a href="schedule_list.php">Visualizar Agendamentos</a></li>

        <!-- Link para logout -->
        <li><a href="/src/logout.php">Logout</a></li>
    </ul>
</body>
</html>
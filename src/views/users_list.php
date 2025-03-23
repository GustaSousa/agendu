<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION["user_id"]) || $_SESSION["is_admin"] != 1) {
    die("Acesso negado. Somente administradores podem gerenciar usuários.");
}

try {
    // Obter todos os usuários
    $stmt = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao obter usuários: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="/public/assets/css/lists.css">
</head>
<body>
    <h1>Usuários</h1>

    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Setor</th>
                <th>Administrador</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['department']); ?></td>
                    <td><?php echo $usuario['is_admin'] ? 'Sim' : 'Não'; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $usuario['id']; ?>">Editar</a>
                        <a href="delet_user.php?id=<?php echo $usuario['id']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
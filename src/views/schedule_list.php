<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. Faça login.");
}

$is_admin = $_SESSION["is_admin"];

try {
    // Buscar agendamentos e unir com a tabela de usuários
    $stmt = $pdo->query("
        SELECT agendamentos.*, usuarios.username 
        FROM agendamentos 
        JOIN usuarios ON agendamentos.user_id = usuarios.id
        ORDER BY date ASC, start_time ASC
    ");
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao obter agendamentos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="/public/assets/css/lists.css">
</head>
<body>
    <div class="voltar">
        <a href="/src/views/dashboard.php">Voltar</a>
    </div>

    <h1>Agendamentos</h1>

    <table>
        <thead>
            <tr>
                <th>Ambiente</th>
                <th>Local</th>
                <th>Atividade</th>
                <th>Data</th>
                <th>Hora de Início</th>
                <th>Hora de Término</th>
                <th>Responsável</th>
                <th>Contato</th>
                <th>Audiovisual</th>
                <?php if ($is_admin): ?>
                    <th>Criado Por</th>
                    <th>Criado Em</th>
                    <th>User ID</th>
                <?php endif; ?>
                <?php if ($is_admin): ?>
                    <th>Ações</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($agendamento['room_type']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['room_name']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['activity']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['date']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['start_time']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['end_time']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['responsible_person']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['contact_info']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['av_requirements']); ?></td>
                    <?php if ($is_admin): ?>
                        <td><?php echo htmlspecialchars($agendamento['username']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['user_id']); ?></td>
                    <?php endif; ?>
                    <?php if ($is_admin): ?>
                        <td>
                            <a href="edit_schedule.php?id=<?php echo $agendamento['id']; ?>">Editar</a>
                            <a href="delete_schedule.php?id=<?php echo $agendamento['id']; ?>">Excluir</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
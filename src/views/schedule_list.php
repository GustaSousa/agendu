<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. Faça login.");
}

$is_admin = $_SESSION["is_admin"];

try {
    // Obter todos os agendamentos
    $stmt = $pdo->query("SELECT * FROM agendamentos ORDER BY date, start_time");
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao obter agendamentos: " . $e->getMessage());
}
?>

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
                <?php if ($is_admin): ?>
                    <td>
                        <a href="edit_schedule?id=<?php echo $agendamento['id']; ?>">Editar</a>
                        <a href="delete_schedule.php?id=<?php echo $agendamento['id']; ?>">Excluir</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. Faça login.");
}

$is_admin = $_SESSION["is_admin"];
$agendamento_id = $_GET['id'] ?? null;

if (!$agendamento_id) {
    die("ID de agendamento inválido.");
}

try {
    // Verificar se o agendamento existe
    $stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id = ?");
    $stmt->execute([$agendamento_id]);
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$agendamento) {
        die("Agendamento não encontrado.");
    }

    // Caso o usuário não seja admin, negar acesso
    if (!$is_admin) {
        die("Acesso negado. Somente administradores podem editar agendamentos.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Atualizar agendamento
        $room_type = trim($_POST["room_type"]);
        $room_name = trim($_POST["room_name"]);
        $activity = trim($_POST["activity"]);
        $date = trim($_POST["date"]);
        $start_time = trim($_POST["start_time"]);
        $end_time = trim($_POST["end_time"]);
        $responsible_person = trim($_POST["responsible_person"]);
        $contact_info = trim($_POST["contact_info"]);

        try {
            $stmt = $pdo->prepare("
                UPDATE agendamentos
                SET room_type = ?, room_name = ?, activity = ?, date = ?, start_time = ?, end_time = ?, responsible_person = ?, contact_info = ?
                WHERE id = ?
            ");
            $stmt->execute([$room_type, $room_name, $activity, $date, $start_time, $end_time, $responsible_person, $contact_info, $agendamento_id]);
            echo "Agendamento atualizado com sucesso!";
        } catch (Exception $e) {
            die("Erro ao atualizar agendamento: " . $e->getMessage());
        }
    }
} catch (Exception $e) {
    die("Erro ao obter dados do agendamento: " . $e->getMessage());
}
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="/public/assets/css/forms.css">
</head>
<body>
    <h1>Editar Agendamento</h1>

    <form method="POST">
        <input type="text" name="room_type" value="<?php echo htmlspecialchars($agendamento['room_type']); ?>" required>
        <input type="text" name="room_name" value="<?php echo htmlspecialchars($agendamento['room_name']); ?>" required>
        <input type="text" name="activity" value="<?php echo htmlspecialchars($agendamento['activity']); ?>" required>
        <input type="date" name="date" value="<?php echo htmlspecialchars($agendamento['date']); ?>" required>
        <input type="time" name="start_time" value="<?php echo htmlspecialchars($agendamento['start_time']); ?>" required>
        <input type="time" name="end_time" value="<?php echo htmlspecialchars($agendamento['end_time']); ?>" required>
        <input type="text" name="responsible_person" value="<?php echo htmlspecialchars($agendamento['responsible_person']); ?>" required>
        <input type="text" name="contact_info" value="<?php echo htmlspecialchars($agendamento['contact_info']); ?>" required>
        <button type="submit">Salvar alterações</button>
    </form>
</body>
</html>
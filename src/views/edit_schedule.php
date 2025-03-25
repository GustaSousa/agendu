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
        $participants_count = trim($_POST["participants_count"]);
        $responsible_person = trim($_POST["responsible_person"]);
        $contact_info = trim($_POST["contact_info"]);
        $av_requirements = trim($_POST["av_requirements"]);

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
    <div class="voltar">
        <a href="/src/views/schedule_list.php">Voltar</a>
    </div>

    <h1>Editar Agendamento</h1>

    <form method="POST">
        <select id="room_type" name="room_type" onchange="atualizarSalas()" required>
            <option value="<?php echo htmlspecialchars($agendamento['room_type']); ?>"><?php echo htmlspecialchars($agendamento['room_type']); ?></option>
            <option value="Auditórios">Auditórios</option>
            <option value="Salas">Salas</option>
            <option value="TICs">TICs</option>
            <option value="Outros">Outros</option>
        </select>

        <select id="room_name" name="room_name" required>
            <option value="<?php echo htmlspecialchars($agendamento['room_name']); ?>" disabled selected><?php echo htmlspecialchars($agendamento['room_name']); ?></option>
        </select>

        <input type="text" name="activity" value="<?php echo htmlspecialchars($agendamento['activity']); ?>" list="atividades" required>

        <label for="date" class="schedule_label">Data:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($agendamento['date']); ?>" required>

        <label for="start_time" class="schedule_label">Hora do inicío:</label>
        <input type="time" name="start_time" value="<?php echo htmlspecialchars($agendamento['start_time']); ?>" required>

        <label for="end_time" class="schedule_label">Hora do Término:</label>
        <input type="time" name="end_time" value="<?php echo htmlspecialchars($agendamento['end_time']); ?>" required>

        <input type="number" name="participants_count" value="<?php echo htmlspecialchars($agendamento['participants_count']); ?>" required>

        <input type="text" name="responsible_person" value="<?php echo htmlspecialchars($agendamento['responsible_person']); ?>" required>

        <input type="text" name="contact_info" value="<?php echo htmlspecialchars($agendamento['contact_info']); ?>" required>

        <input type="text" name="av_requeriments" value="<?php echo htmlspecialchars($agendamento['av_requeriments']); ?>" list="audiovisual" required>

        <button type="submit">Salvar alterações</button>

        <datalist id="atividades">
            <option value="Aula">Aula</option>
            <option value="Conferência">Conferência</option>
            <option value="Palestra">Palestra</option>
            <option value="Reunião">Reunião</option>
            <option value="Ligas">Ligas</option>
        </datalist>

        <datalist id="audiovisual">
            <option value="Microfone">Microfone</option>
            <option value="Sistema de Som">Sistema de Som</option>
            <option value="Videoconferência">Videoconferência</option>
            <option value="Computador">Computador</option>
            <option value="Outros">Outros</option>
        </datalist>

        <script src="/public/assets/js/update_rooms.js"></script>
        <script src="/public/assets/js/av_requeriments.js"></script>
        <script src="/public/assets/js/fake_placeholder.js"></script>
    </form>
</body>

</html>
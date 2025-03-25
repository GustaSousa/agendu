<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. Faça <a href='login.php'>login</a>.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"]; // Pega o ID do usuário logado
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
        // Verifica se já existe um agendamento para essa sala e horário
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM agendamentos 
            WHERE room_name = ? 
            AND date = ?
            AND (
                (start_time >= ? AND start_time < ?) OR 
                (end_time > ? AND end_time <= ?) OR
                (start_time <= ? AND end_time >= ?)
            )
        ");
        $stmt->execute([$room_name, $date, $start_time, $end_time, $start_time, $end_time, $start_time, $end_time]);

        $conflitos = $stmt->fetchColumn();

        if ($conflitos > 0) {
            echo "<script>
                alert('Erro: Já existe um agendamento para essa sala neste horário.');
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 100);
            </script>";
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO agendamentos 
            (user_id, room_type, room_name, activity, date, start_time, end_time, participants_count, responsible_person, contact_info, av_requirements, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
        ");
        $stmt->execute([$user_id, $room_type, $room_name, $activity, $date, $start_time, $end_time, $participants_count, $responsible_person, $contact_info, $av_requirements]);

        echo "Agendamento realizado com sucesso!";
        //cria um alert e enviar usuario para o schedule list
        echo "<script>
            alert('Agendamento realizado com sucesso!');
            setTimeout(function() {
                window.location.href = 'schedule_list.php';
            }, 100);
        </script>";
    } catch (Exception $e) {
        die("Erro ao agendar: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="/public/assets/css/forms.css">
</head>

<body>
    <div class="voltar">
        <a href="/src/views/dashboard.php">Voltar</a>
    </div>

    <h1>
        Novo Agendamento
    </h1>

    <form method="POST">
        <!-- Campo de tipo de ambiente -->
        <select id="room_type" name="room_type" onchange="atualizarSalas()" required>
            <option value="" disabled selected>Selecione o tipo de ambiente</option>
            <option value="Auditórios">Auditórios</option>
            <option value="Salas">Salas</option>
            <option value="TICs">TICs</option>
            <option value="Outros">Outros</option>
        </select>
        <!-- Campo de nome do local (sala ou auditório) -->
        <select id="room_name" name="room_name" required>
            <option value="" disabled selected>Selecione o nome do local</option>
        </select>

        <input type="text" name="activity" placeholder="Atividade" list="atividades" required>

        <label for="date">Data:</label>
        <input type="date" name="date" class="fake-placeholder-ios" required>

        <label for="start_time">Hora do inicío:</label>
        <input type="time" name="start_time" class="fake-placeholder-ios start-time" required>

        <label for="end_time">Hora do Término:</label>
        <input type="time" name="end_time" class="fake-placeholder-ios end-time" required>

        <input type="number" name="participants_count" placeholder="Número de Participantes" required>

        <input type="text" name="responsible_person" placeholder="Responsável" required>

        <input type="text" name="contact_info" placeholder="Contato" required>

        <input type="text" id="av_requirements" placeholder="Audiovisual, adicione e pressione Enter" list="audiovisual">

        <div id="selectedItems"></div>

        <input type="hidden" name="av_requirements" id="hidden_av_requirements" required>

        <button type="submit">Agendar</button>
    </form>

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
</body>

</html>
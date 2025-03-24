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
            <input type="text" name="room_type" placeholder="Tipo de Ambiente (Sala, Auditório)" required>
            <input type="text" name="room_name" placeholder="Nome do Local" required>
            <input type="text" name="activity" placeholder="Atividade" required>
            <input type="date" name="date" required>
            <input type="time" name="start_time" required>
            <input type="time" name="end_time" required>
            <input type="number" name="participants_count" placeholder="Número de Participantes" required>
            <input type="text" name="responsible_person" placeholder="Responsável" required>
            <input type="text" name="contact_info" placeholder="Contato" required>
            <input type="text" name="av_requirements" placeholder="Necessidades Audiovisuais (Câmera, Microfone...)" required>
            <button type="submit">Agendar</button>
    </form>
</body>
</html>
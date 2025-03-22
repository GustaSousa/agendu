<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. <a href='login.php'>Faça login</a>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_type = $_POST["room_type"];
    $room_name = $_POST["room_name"];
    $activity = $_POST["activity"];
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $participants_count = $_POST["participants_count"];
    $responsible_person = $_SESSION["username"];
    $contact_info = $_POST["contact_info"];
    $av_requirements = $_POST["av_requirements"];

    try {
        $stmt = $pdo->prepare("INSERT INTO agendamentos (room_type, room_name, activity, date, start_time, end_time, participants_count, responsible_person, contact_info, av_requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$room_type, $room_name, $activity, $date, $start_time, $end_time, $participants_count, $responsible_person, $contact_info, $av_requirements]);
        echo "Agendamento criado com sucesso!";
    } catch (Exception $e) {
        die("Erro ao criar agendamento: " . $e->getMessage());
    }
}
?>

<form method="POST">
    <input type="text" name="room_type" placeholder="Tipo de Ambiente (Sala, Auditório)" required>
    <input type="text" name="room_name" placeholder="Nome do Local" required>
    <input type="text" name="activity" placeholder="Atividade" required>
    <input type="date" name="date" required>
    <input type="time" name="start_time" required>
    <input type="time" name="end_time" required>
    <input type="number" name="participants_count" placeholder="Número de Participantes" required>
    <input type="text" name="contact_info" placeholder="Contato" required>
    <input type="text" name="av_requirements" placeholder="Necessidades Audiovisuais (Câmera, Microfone...)" required>
    <button type="submit">Agendar</button>
</form>
<?php
session_start();
require '../src/config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sala = $_POST["sala"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $setor = $_POST["setor"];

    $stmt = $pdo->prepare("INSERT INTO agendamentos (usuario_id, sala, data, hora, setor) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user['id'], $sala, $data, $hora, $setor]);

    echo "Agendamento realizado com sucesso!";
}
?>

<form method="POST">
    Sala: <input type="text" name="sala" required><br>
    Data: <input type="date" name="data" required><br>
    Hora: <input type="time" name="hora" required><br>
    Setor: 
    <select name="setor">
        <option value="Audiovisual">Audiovisual</option>
        <option value="Administração">Administração</option>
    </select><br>
    <button type="submit">Agendar</button>
</form>
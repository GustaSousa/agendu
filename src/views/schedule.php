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
            <option >Selecione o tipo de ambiente</option>
            <option value="Auditórios">Auditórios</option>
            <option value="Salas">Salas</option>
            <option value="TICs">TICs</option>
            <option value="Outros">Outros</option>
        </select>
        <!-- Campo de nome do local (sala ou auditório) -->
        <select id="room_name" name="room_name" required>
            <option value="">Nome do Local</option>
        </select>
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

    <script>
        function atualizarSalas() {
            var roomType = document.getElementById("room_type").value;
            var roomNameSelect = document.getElementById("room_name");

            // Limpar as opções atuais do room_name
            roomNameSelect.innerHTML = "<option value=''>Selecione o nome do local</option>";

            // Adicionar as opções válidas com base no roomType selecionado
            if (roomType == "Auditórios") {
                var salas = ["Ana Cardoso", "Praia", "Palmeira", "Bromélia"];
                salas.sort(); // Ordenar as salas alfabeticamente
                salas.forEach(function(sala) {
                    var option = document.createElement("option");
                    option.value = sala;
                    option.textContent = sala;
                    roomNameSelect.appendChild(option);
                });
            } else if (roomType == "Salas") {
                for (var i = 101; i <= 109; i++) { // Exemplo de salas 101 a 105
                    var option = document.createElement("option");
                    option.value = i;
                    option.textContent = "Sala " + i;
                    roomNameSelect.appendChild(option);
                }
                for (var i = 201; i <= 215; i++) { // Exemplo de salas 101 a 105
                    var option = document.createElement("option");
                    option.value = i;
                    option.textContent = "Sala " + i;
                    roomNameSelect.appendChild(option);
                }
                for (var i = 301; i <= 303; i++) { // Exemplo de salas 101 a 105
                    var option = document.createElement("option");
                    option.value = i;
                    option.textContent = "Sala " + i;
                    roomNameSelect.appendChild(option);
                }
            } else if (roomType == "TICs") {
                var salas = ["Sala Betha", "Lab. Info. I", "Lab. Info. II"];
                salas.forEach(function(sala) {
                    var option = document.createElement("option");
                    option.value = sala;
                    option.textContent = sala;
                    roomNameSelect.appendChild(option);
                });
            } else if (roomType == "Outros") {
                var salas = ["Biblioteca"];
                salas.sort(); 
                salas.forEach(function(sala) {
                    var option = document.createElement("option");
                    option.value = sala;
                    option.textContent = sala;
                    roomNameSelect.appendChild(option);
                });

                for (var i = 1; i <= 21; i++) { 
                    var option = document.createElement("option");
                    option.value = i;
                    option.textContent = "Tutoria " + i;
                    roomNameSelect.appendChild(option);
                }
            }
        }
    </script>
</body>
</html>
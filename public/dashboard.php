<?php
session_start();
require '../src/config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<h1>Bem-vindo ao Agendu, <?php echo htmlspecialchars($user['nome']); ?>!</h1>
<p>Cargo: <?php echo htmlspecialchars($user['cargo']); ?></p>

<h2>Agendamentos</h2>
<?php
if ($user['cargo'] == 'Administrador') {
    echo '<a href="agendar.php">Cadastrar novo agendamento</a>';
}

$sql = "SELECT * FROM agendamentos WHERE setor = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user['cargo']]);
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($agendamentos as $agendamento) {
    echo "<p> Sala: " . htmlspecialchars($agendamento['sala']) . 
         " | Data: " . htmlspecialchars($agendamento['data']) . 
         " | Hora: " . htmlspecialchars($agendamento['hora']) . 
         " | Setor: " . htmlspecialchars($agendamento['setor']) . "</p>";
}
?>
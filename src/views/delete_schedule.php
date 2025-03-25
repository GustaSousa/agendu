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
    // Caso o usuário não seja admin, negar acesso
    if (!$is_admin) {
        die("Acesso negado. Somente administradores podem excluir agendamentos.");
    }

    // Excluir agendamento
    $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id = ?");
    $stmt->execute([$agendamento_id]);

    echo "Agendamento excluído com sucesso!";
} catch (Exception $e) {
    die("Erro ao excluir agendamento: " . $e->getMessage());
}

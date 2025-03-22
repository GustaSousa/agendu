<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION["user_id"]) || $_SESSION["is_admin"] != 1) {
    die("Acesso negado. Somente administradores podem excluir usuários.");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        // Deletar usuário
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$user_id]);
        echo "Usuário excluído com sucesso!";
    } catch (Exception $e) {
        die("Erro ao excluir usuário: " . $e->getMessage());
    }
}
?>
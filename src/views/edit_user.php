<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION["user_id"]) || $_SESSION["is_admin"] != 1) {
    die("Acesso negado. Somente administradores podem editar usuários.");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        // Obter dados do usuário
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Usuário não encontrado.");
        }
    } catch (Exception $e) {
        die("Erro ao buscar usuário: " . $e->getMessage());
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Atualizar usuário
    $user_id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET username = ?, email = ?, department = ?, is_admin = ? WHERE id = ?");
        $stmt->execute([$username, $email, $department, $is_admin, $user_id]);
        echo "Usuário atualizado com sucesso!";
    } catch (Exception $e) {
        die("Erro ao atualizar usuário: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="/public/assets/css/forms.css">
</head>

<body>
    <div class="voltar">
        <a href="/src/views/users_list.php">Voltar</a>
    </div>

    <h1>Editar Usuário</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <input type="text" name="department" placeholder="Setor" value="<?php echo htmlspecialchars($user['department']); ?>" required>
        <label class="checkbox-label">
            <input type="checkbox" name="is_admin"> 
            <span>Administrador</span>
        </label>
        <button type="submit">Atualizar</button>
    </form>
</body>

</html>
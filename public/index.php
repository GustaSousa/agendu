<?php
// Incluindo a configuração do banco de dados
require_once('../src/config/config.php');

// Roteamento básico para determinar qual página carregar
$page = $_GET['page'] ?? 'home'; // Se não tiver página, redireciona para 'home'

switch ($page) {
    case 'login':
        include_once('../src/views/login.php');
        break;
    case 'register':
        include_once('../src/views/register.php');
        break;
    case 'schedule':
        include_once('../src/views/schedule.php');
        break;
    default:
        include_once('../src/views/home.php');
        break;
}
?>
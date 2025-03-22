<?php
try {
    $db = new PDO('sqlite:banco.db');
    echo "Banco de dados SQLite conectado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}
?>
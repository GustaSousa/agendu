<?php
// Conectar ao banco de dados SQLite
$database = __DIR__ . '/../database/agendu.sqlite';

try {
    $pdo = new PDO("sqlite:$database");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Habilitar chaves estrangeiras (se necessário no futuro)
    $pdo->exec("PRAGMA foreign_keys = ON");

    // Criar tabela usuarios
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE NOT NULL,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            department TEXT NOT NULL,
            is_admin INTEGER NOT NULL DEFAULT 0
        )
    ");

    // Criar tabela agendamentos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS agendamentos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            room_type TEXT NOT NULL,
            room_name TEXT NOT NULL,
            activity TEXT NOT NULL,
            date TEXT NOT NULL,
            start_time TEXT NOT NULL,
            end_time TEXT NOT NULL,
            participants_count INTEGER NOT NULL,
            responsible_person TEXT NOT NULL,
            contact_info TEXT NOT NULL,
            av_requirements TEXT NOT NULL
        )
    ");

    echo "Tabelas criadas com sucesso!";
} catch (Exception $e) {
    die("Erro ao criar tabelas: " . $e->getMessage());
}
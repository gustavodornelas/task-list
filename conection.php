<?php
require_once('configuration.php');
date_default_timezone_set('America/Sao_Paulo');

try {
    $pdo = new PDO("mysql:dbname=$database; host=$server; charset=utf8", "$user", "$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conexao MSQLI para o backup
    $conn = mysqli_connect($server, $user, $password, $database);
    
} catch (Exception $e) {
    echo "Erro ao conectar com o banco de dados... " + $e;
}

?>
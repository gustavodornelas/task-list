<?php
require_once('conection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['taskTitle']) && isset($_POST['taskDescription'])) {
        $taskTitle = $_POST['taskTitle'];
        $taskDescription = $_POST['taskDescription'];

        $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?, 'p')");
        $stmt->execute([$taskTitle, $taskDescription]);

        header("Location: index.php");
        exit();
    }
}

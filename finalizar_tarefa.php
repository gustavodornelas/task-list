<?php
require_once('conection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['taskId'])) {
        $taskId = $_POST['taskId'];

        $stmt = $pdo->prepare("UPDATE tasks SET status = 'f' WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }
}

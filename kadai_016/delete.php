<?php
$dsn = 'mysql:dbname=il8l7duhqqquf96b;host=olxl65dqfuqr6s4y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;charset=utf8mb4';
$user = 'k9t3kpejmokht57v';
$password = 'hbtm2jlra1d1imy6';

try {
    $pdo = new PDO($dsn, $user, $password);

    // idが指定されていない場合は一覧にリダイレクト
    if (!isset($_GET['id'])) {
        header("Location: read.php?message=" . urlencode("IDが指定されていません"));
        exit;
    }

    $sql_delete = 'DELETE FROM books WHERE id = :id';
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt_delete->execute();

    $count = $stmt_delete->rowCount();
    $message = "書籍を{$count}件削除しました。";

    header("Location: read.php?message=" . urlencode($message));
} catch (PDOException $e) {
    exit($e->getMessage());
}

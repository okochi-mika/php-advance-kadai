<?php
$dsn = 'mysql:dbname=php_book_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $user, $password);

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql_insert = 'INSERT INTO books (book_code, book_name, price, stock_quantity, genre_code, created_at, updated_at)
                       VALUES (:book_code, :book_name, :price, :stock_quantity, :genre_code, NOW(), NOW())';
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindValue(':book_code', $_POST['book_code'], PDO::PARAM_INT);
        $stmt_insert->bindValue(':book_name', $_POST['book_name'], PDO::PARAM_STR);
        $stmt_insert->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $stmt_insert->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
        $stmt_insert->bindValue(':genre_code', $_POST['genre_code'], PDO::PARAM_STR);
        $stmt_insert->execute();
    
        // 成功時メッセージとともに一覧へリダイレクト
        header("Location: read.php?message=" . urlencode("書籍を登録しました"));
        exit;
    }
    

    // ジャンルコードを取得
    $sql_genres = 'SELECT genre_code FROM genres';
    $stmt_genres = $pdo->query($sql_genres);
    $genre_codes = $stmt_genres->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    exit($e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍登録</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <a href="index.php">書籍管理アプリ</a>
        </nav>
    </header>
    <main>
        <article class="registration">
            <h1>書籍登録</h1>
            <div class="back">
                <a href="read.php" class="btn">&lt; 戻る</a>
            </div>
            <form action="create.php" method="post" class="registration-form">
                <div>
                    <label for="book_code">書籍コード</label>
                    <input type="number" id="book_code" name="book_code" min="0" max="100000000" required>

                    <label for="book_name">書籍名</label>
                    <input type="text" id="book_name" name="book_name" maxlength="50" required>

                    <label for="price">値段</label>
                    <input type="number" id="price" name="price" min="0" max="100000000" required>

                    <label for="stock_quantity">在庫数</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" min="0" max="100000000" required>

                    <label for="genre_code">ジャンルコード</label>
                    <select id="genre_code" name="genre_code" required>
                        <option disabled selected value>選択してください</option>
                        <?php
                        // 配列の中身を順番に取り出し、セレクトボックスの選択肢として出力する
                        foreach ($genre_codes as $genre_code) {
                            echo "<option value='{$genre_code}'>{$genre_code}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="submit" value="create">登録</button>
            </form>
        </article>
    </main>
    <footer>
        <p class="copyright">&copy; 書籍管理アプリ All rights reserved.</p>
    </footer>
</body>

</html>

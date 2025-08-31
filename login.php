<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <h2>ログイン</h2>
    <form action="login_action.php" method="POST">
        <div>
            <label for="username">ユーザー名:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">ログイン</button>
    </form>
    <p>アカウントをお持ちでないですか？ <a href="register.php">新規登録はこちら</a></p>
</body>
</html>
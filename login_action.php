<?php
// セッションを開始
session_start();

require_once 'db_connect.php';

// POSTリクエストでなければ処理を終了
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('不正なリクエストです。');
}

// フォームから送信されたデータを取得
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // データベースからユーザー名でユーザー情報を取得
    $sql = 'SELECT * FROM users WHERE username = :username';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーが存在し、かつパスワードが正しいか検証
    if ($user && password_verify($password, $user['password'])) {
        // パスワードが正しい場合
        // セッションにユーザー情報を保存する
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // メインページ（index.php）にリダイレクト
        header('Location: reviews.php');
        exit;
    } else {
        // 認証に失敗した場合
        echo 'ユーザー名またはパスワードが間違っています。';
    }

} catch (PDOException $e) {
    echo 'データベースエラー: ' . $e->getMessage();
}
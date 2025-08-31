<?php

// データベース接続ファイルを読み込む
require_once 'db_connect.php';

// POSTリクエストでない場合は処理を終了
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('不正なリクエストです。');
}

// フォームから送信されたデータを取得
$username = $_POST['username'];
$password = $_POST['password'];

// バリデーション
if (empty($username) || empty($password)) {
    exit('ユーザー名とパスワードは必須です。');
}

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// データベースにユーザー情報を挿入
try {
    // SQL文準備
    $sql = 'INSERT INTO users (username, password) VALUES (:username, :password)';
    $stmt = $pdo->prepare($sql);

    // プレースホルダに値をバインド
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);

    // SQLを実行
    $stmt->execute();

    echo 'ユーザー登録が完了しました。';
    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    // エラー処理
    // エラーコード 23000 はユーザー名が重複
    if ($e->getCode() === '23000') {
        echo 'このユーザー名は既に使用されています。';
    } else {
        echo 'データベースエラー: ' . $e->getMessage();
    }
}
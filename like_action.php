<?php
session_start();
require_once 'db_connect.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'ログインが必要です。']);
    exit;
}

// POSTリクエストチェック
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('不正なリクエストです。');
}

$review_id = $_POST['review_id'];
$user_id = $_SESSION['user_id'];

try {
    // すでに「グッド」しているか確認
    $sql = 'SELECT * FROM likes WHERE user_id = :user_id AND review_id = :review_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':review_id', $review_id, PDO::PARAM_INT);
    $stmt->execute();
    $like = $stmt->fetch();

    if ($like) {
        // 存在する場合：グッドを取り消す
        $sql = 'DELETE FROM likes WHERE user_id = :user_id AND review_id = :review_id';
    } else {
        // 存在しない場合：グッドを追加する
        $sql = 'INSERT INTO likes (user_id, review_id) VALUES (:user_id, :review_id)';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':review_id', $review_id, PDO::PARAM_INT);
    $stmt->execute();

    // 成功したら前のページに戻る
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;

} catch (PDOException $e) {
    exit('データベースエラー: ' . $e->getMessage());
}
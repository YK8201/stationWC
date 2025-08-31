<?php
session_start();
require_once 'db_connect.php';

// ログインしていなければ、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// POSTリクエストでなければ、トップページにリダイレクト
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reviews.php');
    exit;
}

// フォームから送信されたデータを取得
$station_id = $_POST['station_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$user_id = $_SESSION['user_id'];

// 設備情報のチェックボックス値を取得
$has_washlet = isset($_POST['has_washlet']) ? 1 : 0;
$has_multipurpose = isset($_POST['has_multipurpose']) ? 1 : 0;
$has_diaper_stand = isset($_POST['has_diaper_stand']) ? 1 : 0;
$has_changing_board = isset($_POST['has_changing_board']) ? 1 : 0;
$has_baby_chair = isset($_POST['has_baby_chair']) ? 1 : 0;

try {
    // reviewsテーブルに投稿内容を登録
    $sql = 'INSERT INTO reviews (user_id, station_id, rating, comment, has_washlet, has_multipurpose, has_diaper_stand, has_changing_board, has_baby_chair) 
            VALUES (:user_id, :station_id, :rating, :comment, :has_washlet, :has_multipurpose, :has_diaper_stand, :has_changing_board, :has_baby_chair)';
    
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':station_id', $station_id, PDO::PARAM_INT);
    $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':has_washlet', $has_washlet, PDO::PARAM_INT);
    $stmt->bindValue(':has_multipurpose', $has_multipurpose, PDO::PARAM_INT);
    $stmt->bindValue(':has_diaper_stand', $has_diaper_stand, PDO::PARAM_INT);
    $stmt->bindValue(':has_changing_board', $has_changing_board, PDO::PARAM_INT);
    $stmt->bindValue(':has_baby_chair', $has_baby_chair, PDO::PARAM_INT);
    
    $stmt->execute();

    // 投稿完了後、レビュー一覧ページに戻る
    header('Location: reviews.php');
    exit;

} catch (PDOException $e) {
    // エラー発生時は、より詳細な情報を表示
    echo "データベースエラー: " . $e->getMessage();
    exit;
}
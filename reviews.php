<?php
// --- エラー表示設定 ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

// ログインしているユーザーのIDを取得 (ログインしていない場合は0)
$current_user_id = $_SESSION['user_id'] ?? 0;

// 最新のレビューを取得するSQL
$sql = 'SELECT 
            r.*, 
            u.username, 
            s.name AS station_name, 
            l.name AS line_name,
            c.name AS company_name,
            (SELECT COUNT(*) FROM likes WHERE review_id = r.id) AS like_count,
            (SELECT COUNT(*) FROM likes WHERE review_id = r.id AND user_id = :user_id) AS user_liked
        FROM 
            reviews AS r
        LEFT JOIN 
            users AS u ON r.user_id = u.id 
        LEFT JOIN 
            stations AS s ON r.station_id = s.id
        LEFT JOIN 
            `lines` AS l ON s.line_id = l.id
        LEFT JOIN 
            companies AS c ON l.company_id = c.id
        ORDER BY 
            r.created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー一覧 - 駅トイレ評価サイト</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; // ヘッダーを読み込む ?>

    <div class="container">
        <h2>最新のレビュー</h2>
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>

                <div class="review-card">
                    <div class="review-header">
                        <?php echo htmlspecialchars($review['station_name'] ?? '不明な駅', ENT_QUOTES, 'UTF-8'); ?>駅 (<?php echo htmlspecialchars($review['company_name'] ?? '不明', ENT_QUOTES, 'UTF-8'); ?>:<?php echo htmlspecialchars($review['line_name'] ?? '不明', ENT_QUOTES, 'UTF-8'); ?>)
                        <span style="float: right; color: #f39c12; font-weight: bold;">評価: ★<?php echo $review['rating']; ?></span>
                    </div>
                    <div class="review-meta">
                        投稿者: <?php echo htmlspecialchars($review['username'] ?? '不明なユーザー', ENT_QUOTES, 'UTF-8'); ?> | 投稿日時: <?php echo $review['created_at']; ?>
                    </div>

                    <div class="review-equipment">
                        <?php if ($review['has_washlet']): ?>
                            <span class="equipment-tag">🚽 ウォシュレット</span>
                        <?php endif; ?>
                        <?php if ($review['has_multipurpose']): ?>
                            <span class="equipment-tag">♿️ 多目的トイレ</span>
                        <?php endif; ?>
                        <?php if ($review['has_diaper_stand']): ?>
                            <span class="equipment-tag">👶 おむつ交換台</span>
                        <?php endif; ?>
                        <?php if ($review['has_changing_board']): ?>
                            <span class="equipment-tag">🚪 フィッティングボード</span>
                        <?php endif; ?>
                        <?php if ($review['has_baby_chair']): ?>
                            <span class="equipment-tag">🚼 ベビーチェア</span>
                        <?php endif; ?>
                    </div>

                    <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8')); ?></p>

                    <div class="review-actions">
                        <form action="like_action.php" method="POST" style="display: inline;">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" class="like-button <?php echo $review['user_liked'] ? 'liked' : ''; ?>">
                                👍 グッド
                            </button>
                        </form>
                        <span class="like-count"><?php echo $review['like_count']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>まだレビューはありません。</p>
        <?php endif; ?>
    </div>

</body>
</html>
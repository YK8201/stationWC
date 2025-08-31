<header class="site-header">
    <div class="header-container">
        
        <a href="reviews.php" class="logo">駅トイレ評価サイト</a>

        <div class="nav-center">
            <a href="reviews.php">レビュー一覧</a>
            <a href="post.php">投稿する</a>
        </div>

        <div class="nav-right">
            <?php if (isset($_SESSION['username'])): ?>
                <span class="user-greeting">こんにちは、<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>さん</span>
                <a href="logout.php">ログアウト</a>
            <?php else: ?>
                <a href="login.php">ログイン</a>
            <?php endif; ?>
        </div>
        
    </div>
</header>
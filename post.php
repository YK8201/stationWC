<?php
session_start();
require_once 'db_connect.php';

// ログインしていなければログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// ドロップダウン用のデータを取得
$companies = $pdo->query('SELECT * FROM companies ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
$lines = $pdo->query('SELECT * FROM `lines` ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
$stations = $pdo->query('SELECT * FROM stations ORDER BY id ASC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビューを投稿 - 駅トイレ評価サイト</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; // ヘッダーを読み込む ?>
    <div class="container">
        <div class="form-section">
            <h2>トイレ情報を投稿する</h2>
            <form action="post_review.php" method="POST">
                
                <div>
                    <label for="company">鉄道会社:</label>
                    <select name="company_id" id="company" required>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?php echo $company['id']; ?>"><?php echo htmlspecialchars($company['name'], ENT_QUOTES); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="line">路線名:</label>
                    <select name="line_id" id="line" required>
                        <option value="">-- 路線を選択 --</option>
                        <?php foreach ($lines as $line): ?>
                            <option value="<?php echo $line['id']; ?>" data-company-id="<?php echo $line['company_id']; ?>" style="display: none;">
                                <?php echo htmlspecialchars($line['name'], ENT_QUOTES); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="station">駅名:</label>
                    <select name="station_id" id="station" required>
                        <option value="">-- 駅を選択 --</option>
                        <?php foreach ($stations as $station): ?>
                            <option value="<?php echo $station['id']; ?>" data-line-id="<?php echo $station['line_id']; ?>" style="display: none;">
                                <?php echo htmlspecialchars($station['name'], ENT_QUOTES); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 25px 0;">

                <div>
                    <label>清潔度評価:</label>
                    <select name="rating" required>
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                        <option value="2">★★☆☆☆ (2)</option>
                        <option value="1">★☆☆☆☆ (1)</option>
                    </select>
                </div>
                <div>
                    <label>設備:</label><br>
                    <label class="checkbox-label">
                        <input type="checkbox" name="has_washlet" value="1"> ウォシュレット
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="has_multipurpose" value="1"> 多目的トイレ
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="has_diaper_stand" value="1"> おむつ交換台
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="has_changing_board" value="1"> フィッティングボード
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="has_baby_chair" value="1"> ベビーチェア
                    </label>
                </div>                    
                <div>
                    <label>コメント:</label><br>
                    <textarea name="comment" rows="4" cols="50" required></textarea>
                </div>

                <button type="submit">投稿する</button>
            </form>
        </div>
    </div>
    <script>
        // ドロップダウンの要素を取得
        const companySelect = document.getElementById('company');
        const lineSelect = document.getElementById('line');
        const stationSelect = document.getElementById('station');

        // 会社が選択された時の処理
        companySelect.addEventListener('change', function() {
            const selectedCompanyId = this.value;
            
            // 路線と駅の選択をリセット
            lineSelect.value = '';
            stationSelect.value = '';

            // 全ての路線オプションをループ
            for (const option of lineSelect.options) {
                if (option.value === '') continue;
                
                // 選択された会社の路線なら表示、それ以外は非表示
                if (option.dataset.companyId === selectedCompanyId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
            
            // 全ての駅オプションを一旦非表示にする
            for (const option of stationSelect.options) {
                if (option.value !== '') {
                    option.style.display = 'none';
                }
            }
        });

        // 路線が選択された時の処理
        lineSelect.addEventListener('change', function() {
            const selectedLineId = this.value;

            // 駅の選択をリセット
            stationSelect.value = '';
            
            // 全ての駅オプションをループ
            for (const option of stationSelect.options) {
                // プレースホルダー「-- 駅を選択 --」はスキップ
                if (option.value === '') continue;
                
                // 選択された路線の駅なら表示、それ以外は非表示
                if (option.dataset.lineId === selectedLineId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        });

        // ページ読み込み時に一度、会社の選択イベントを実行して初期状態を設定
        companySelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
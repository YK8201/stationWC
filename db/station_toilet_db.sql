-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2025-08-31 08:14:42
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `station_toilet_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(1, '阪急電鉄');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `lines`
--

CREATE TABLE `lines` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `lines`
--

INSERT INTO `lines` (`id`, `company_id`, `name`) VALUES
(1, 1, '神戸本線'),
(2, 1, '宝塚本線'),
(3, 1, '京都本線'),
(11, 1, '伊丹線'),
(12, 1, '今津線'),
(13, 1, '甲陽線'),
(21, 1, '箕面線'),
(31, 1, '千里線'),
(32, 1, '嵐山線');

-- --------------------------------------------------------

--
-- テーブルの構造 `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `has_washlet` tinyint(1) NOT NULL DEFAULT '0',
  `has_multipurpose` tinyint(1) NOT NULL DEFAULT '0',
  `has_diaper_stand` tinyint(1) NOT NULL DEFAULT '0',
  `has_changing_board` tinyint(1) NOT NULL DEFAULT '0',
  `has_baby_chair` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `station_id`, `rating`, `comment`, `has_washlet`, `has_multipurpose`, `has_diaper_stand`, `has_changing_board`, `has_baby_chair`, `created_at`) VALUES
(1, 1, 16, 3, '人が多い', 1, 1, 0, 0, 0, '2025-08-27 18:33:44'),
(2, 1, 55, 4, '人がそんなに多くない', 1, 1, 0, 1, 0, '2025-08-28 03:58:53'),
(3, 1, 8, 4, '人が多い', 1, 1, 0, 0, 1, '2025-08-28 03:59:59'),
(4, 2, 49, 4, 'そこそこ広い', 1, 1, 1, 0, 1, '2025-08-31 07:01:08');

-- --------------------------------------------------------

--
-- テーブルの構造 `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `line_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `stations`
--

INSERT INTO `stations` (`id`, `name`, `line_id`) VALUES
(1, '大阪梅田', 1),
(2, '中津', 1),
(3, '十三', 1),
(4, '神崎川', 1),
(5, '園田', 1),
(6, '塚口', 1),
(7, '武庫之荘', 1),
(8, '西宮北口', 1),
(9, '夙川', 1),
(10, '芦屋川', 1),
(11, '岡本', 1),
(12, '御影', 1),
(13, '六甲', 1),
(14, '王子公園', 1),
(15, '春日野道', 1),
(16, '神戸三宮', 1),
(17, '花隈', 1),
(18, '高速神戸', 1),
(19, '新開地', 1),
(20, '塚口', 11),
(21, '稲野', 11),
(22, '新伊丹', 11),
(23, '伊丹', 11),
(24, '今津', 12),
(25, '阪神国道', 12),
(26, '西宮北口', 12),
(27, '門戸厄神', 12),
(28, '甲東園', 12),
(29, '仁川', 12),
(30, '小林', 12),
(31, '逆瀬川', 12),
(32, '宝塚南口', 12),
(33, '宝塚', 12),
(34, '夙川', 13),
(35, '苦楽園口', 13),
(36, '甲陽園', 13),
(37, '大阪梅田', 2),
(38, '中津', 2),
(39, '十三', 2),
(40, '三国', 2),
(41, '庄内', 2),
(42, '服部天神', 2),
(43, '曽根', 2),
(44, '岡町', 2),
(45, '豊中', 2),
(46, '蛍池', 2),
(47, '石橋阪大前', 2),
(48, '池田', 2),
(49, '川西能勢口', 2),
(50, '雲雀丘花屋敷', 2),
(51, '山本', 2),
(52, '中山観音', 2),
(53, '売布神社', 2),
(54, '清荒神', 2),
(55, '宝塚', 2),
(56, '石橋阪大前', 21),
(57, '桜井', 21),
(58, '牧落', 21),
(59, '箕面', 21),
(60, '大阪梅田', 3),
(61, '十三', 3),
(62, '南方', 3),
(63, '崇禅寺', 3),
(64, '淡路', 3),
(65, '上新庄', 3),
(66, '相川', 3),
(67, '正雀', 3),
(68, '摂津市', 3),
(69, '南茨木', 3),
(70, '茨木市', 3),
(71, '総持寺', 3),
(72, '富田', 3),
(73, '高槻市', 3),
(74, '上牧', 3),
(75, '水無瀬', 3),
(76, '大山崎', 3),
(77, '西山天王山', 3),
(78, '長岡天神', 3),
(79, '西向日', 3),
(80, '東向日', 3),
(81, '洛西口', 3),
(82, '桂', 3),
(83, '西京極', 3),
(84, '西院', 3),
(85, '大宮', 3),
(86, '烏丸', 3),
(87, '京都河原町', 3),
(88, '天神橋筋六丁目', 31),
(89, '柴島', 31),
(90, '淡路', 31),
(91, '下新庄', 31),
(92, '吹田', 31),
(93, '豊津', 31),
(94, '関大前', 31),
(95, '千里山', 31),
(96, '南千里', 31),
(97, '山田', 31),
(98, '北千里', 31),
(99, '桂', 32),
(100, '上桂', 32),
(101, '松尾大社', 32),
(102, '嵐山', 32);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'test_strong_man', '$2y$10$7BMlVJa/IospQjkU9j6fKeBveDMWCqytk/eU1p58kTLI.uLT/vs1.', '2025-08-27 16:25:51'),
(2, 'user', '$2y$10$IIYv.XbgkPp5M39V3yRH2.l72GWrZV547stitK8CPt9VoNujQNKfC', '2025-08-31 06:57:50');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`review_id`),
  ADD KEY `review_id` (`review_id`);

--
-- テーブルのインデックス `lines`
--
ALTER TABLE `lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- テーブルのインデックス `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station_id` (`station_id`);

--
-- テーブルのインデックス `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `line_id` (`line_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `lines`
--
ALTER TABLE `lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- テーブルの AUTO_INCREMENT `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `lines`
--
ALTER TABLE `lines`
  ADD CONSTRAINT `lines_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- テーブルの制約 `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`);

--
-- テーブルの制約 `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`line_id`) REFERENCES `lines` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

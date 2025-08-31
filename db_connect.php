<?php

// データベース接続情報
const DB_HOST = 'localhost';
const DB_NAME = 'station_toilet_db';
const DB_USER = 'root';
const DB_PASS = 'root';

try {
    // データベースに接続
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);

    // エラー発生時に例外をスローするように設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 接続エラーの際にメッセージを出力して終了
    echo 'データベース接続に失敗しました: ' . $e->getMessage();
    exit;
}
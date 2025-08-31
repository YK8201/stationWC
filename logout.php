<?php
// セッションを開始
session_start();

// セッション変数をすべて空にする
$_SESSION = array();

// セッションを破棄する
session_destroy();

// ログインページにリダイレクト
header('Location: login.php');
exit;
<?php
// var_dump($_POST);
// exit();
session_start();

// 外部ファイル読み込み
include("functions.php");

// DB接続します
$pdo = connect_to_db();

$customer_id = $_POST["customer_id"];
$customer_password = $_POST["customer_password"];

// データ取得SQL作成&実行
$sql = 'SELECT * FROM customers_table WHERE customer_id=:customer_id AND customer_password=:customer_password AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_STR);
$stmt->bindValue(':customer_password', $customer_password, PDO::PARAM_STR);
$status = $stmt->execute();

// SQL実行時にエラーがある場合
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

// うまくいったらデータ（1レコード）を取得
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザ情報が取得できない場合はメッセージを表示
if (!$val) {
  echo "<p>ログイン情報に誤りがあります．</p>";
  echo '<a href="login.php">login</a>';
  exit();

  //ユーザー情報が取得できたら、SESSION領域の変数にデータを保存
} else {
  $_SESSION = array();
  $_SESSION["session_id"] = session_id();
  $_SESSION["customer_id"] = $val["customer_id"];
  $_SESSION["id"] = $val["id"];
  // header("Location:todo_read.php");
  echo ('yeah!');
  exit();
}

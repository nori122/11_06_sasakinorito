<?php

// var_dump($_POST);
// exit();

// 関数ファイル読み込み
include('functions.php');

// データ受け取り
$customer_name = $_POST["customer_name"];
$customer_id = $_POST["customer_id"];
$customer_password = $_POST["customer_password"];

// DB接続関数
$pdo = connect_to_db();

// ユーザ存在有無確認
$sql = 'SELECT COUNT(*) FROM customers_table WHERE customer_id=:customer_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  // customer_idが1件以上該当した場合はエラーを表示して元のページに戻る
  // $count = $stmt->fetchColumn();
  echo "<p>すでに登録されているユーザです．</p>";
  echo '<a href="login.php">login</a>';
  exit();
}

// ユーザ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO `customers_table`(`id`, `customer_name`, `customer_id`, `customer_password`, `is_deleted`, `created_at`) VALUES (NULL, :customer_name, :customer_id, :customer_password, 0, sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':customer_name', $customer_name, PDO::PARAM_STR);
$stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_STR);
$stmt->bindValue(':customer_password', $customer_password, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  echo "<script>alert('テスト');</script>";
  header("Location:login.php");
  exit();
}

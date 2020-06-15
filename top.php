<!---------------------
     php 要素
--------------------->



<?PHP

session_start();
include("functions.php");
check_session_id();


// var_dump($_SESSION);
// exit();

// ユーザ名取得
$customer_id = $_SESSION['customer_id'];

// DB接続
$pdo = connect_to_db();


$output = "ここにSQLのlikeで取得したお気にりいのマッサージ師のカードが３つくらい入る予定"


?>




<!---------------------
     HTML 要素
--------------------->



<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='styles.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>top</title>
</head>

<body>
    <p><?= $customer_id ?>さんマイページ</p>
    <button><a href='search.php'>メニューから探す</a></button>


    <p>お気に入りリスト</p>
    <div style="border:solid 1px"><?= $output ?></div>


</body>

</html>
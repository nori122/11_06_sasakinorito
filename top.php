<!---------------------
     php 要素
--------------------->
<?PHP

session_start();
include("functions.php");
check_session_id();


// var_dump($_SESSION);
// exit();


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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>top</title>
</head>

<body>
    <div><a href='top.php'><i class="fas fa-home"></i></a><?= $_SESSION['customer_id'] ?>さん </div>

    <p><button><a href='masseurs.php'>マッサージ師一覧</a></button></p>
    <p><button><a href='search.php'>メニューから探す</a></button></p>


    <!-- <p>お気に入りリスト</p>
    <div style="border:solid 1px"><?= $output ?></div> -->


</body>

</html>
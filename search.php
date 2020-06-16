<!---------------------
php 要素
--------------------->
<?PHP
session_start();
include("functions.php");
check_session_id();


// var_dump($_SESSION);
// exit();


?>



<!---------------------
HTML 要素
--------------------->
<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <link rel='stylesheet' href='styles.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>search</title>
</head>

<body>
    <div><a href='top.php'><i class="fas fa-home"></i></a><?= $_SESSION['customer_name'] ?>さん </div>

    <!-- マッサージメニューを選択 -->
    <form action="search_act.php" method="POST">
        <fieldset>
            <legend>メニュー</legend>
            <p><label><input type="checkbox" name="menu[]" value='フット'>フットマッサージ</label></p>
            <p><label><input type="checkbox" name="menu[]" value='ボディ'>ボディマッサージ</label></p>
            <p><label><input type="checkbox" name="menu[]" value='ヘッド'>ヘッドマッサージ</label></p>
            <p><label><input type="checkbox" name="menu[]" value='オイル'>オイルマッサージ</label></p>
        </fieldset>

        <!-- 価格レンジを選択 -->
        <fieldset>
            <legend>Price</legend>
            <input type='number' name='min_price' id='min_price'>
            <span>円~ </span>
            <input type='number' name='max_price' id='max_price'>
            <span>円</span>
        </fieldset>

        <!-- 送信ボタン -->
        <button>検索</button>
    </form>


</body>

</html>
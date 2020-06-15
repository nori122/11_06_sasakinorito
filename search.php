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
    <link rel='stylesheet' href='styles.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>search</title>
</head>

<body>
    <!-- マッサージメニューを選択 -->
    <form action="search_act.php" method="POST">
        <fieldset>
            <legend>メニュー</legend>
            <p><label><input type="checkbox" name="menu[]" value="フット">フットマッサージ</label></p>
            <p><label><input type="checkbox" name="menu[]" value="ボディ">ボディマッサージ</label></p>
            <p><label><input type="checkbox" name="menu[]" value="ヘッド">ヘッドマッサージ</label></p>
            <p><label><input type="checkbox" name="menu[]" value="オイル">オイルマッサージ</label></p>
        </fieldset>

        <!-- 価格レンジを選択 -->
        <fieldset>
            <legend>Price</legend>
            <input type='tel' name='price[]' id='price_min'>
            <span>円~ </span>
            <input type='tel' name='price[]' id='price_max'>
            <span>円</span>
        </fieldset>

        <!-- 送信ボタン -->
        <button>検索</button>
    </form>


</body>

</html>
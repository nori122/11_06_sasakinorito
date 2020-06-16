<!---------------------
     php 要素
--------------------->
<?PHP
session_start();
include("functions.php");
check_session_id();

//DBに接続
$pdo = connect_to_db();

//masseurs_tableのデータを全て取得
$sql = "SELECT * FROM masseurs_table";

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $masseurs = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // var_dump($masseurs);
    // exit();
    $php_json_masseurs = json_encode($masseurs);
}

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

    <title>masseur list</title>
</head>

<body>
    <div><a href='top.php'><i class="fas fa-home"></i></a><?= $_SESSION['customer_name'] ?>さん </div>

    <h2>マッサージ師一覧</h2>
    <div id="masseurs"></div>
    <a href='top.php'>topへ戻る</a>



    <!---------------------
         javascript 要素
    --------------------->
    <script>
        //phpからマッサージ師リストの配列を取得しjs_masseursに代入する
        let js_masseurs = <?php echo $php_json_masseurs; ?>;
        console.log(js_masseurs);

        //js_masseursからHTMLタグを含むmasseursListを作成する
        let masseursList = [];
        for (var i = 0; i < js_masseurs.length; i++) {
            masseursList.push('<div class="card">');
            masseursList.push('<img src="img/seitaishi_man.png" alt="整体師" class="masseurImg">');
            masseursList.push('<div class="cardText">');
            masseursList.push('<p style="font-weight: bold;">' + js_masseurs[i]['masseur_name'] + '</p>');
            masseursList.push('<div>レビュー：' + js_masseurs[i]['masseur_rate'] + '</div>');
            masseursList.push('<div>勤務サロン：' + js_masseurs[i]['masseur_salon'] + '</div>');
            masseursList.push('<div>コメント：' + js_masseurs[i]['masseur_comment'] + '</div>');
            masseursList.push('</div>');
            masseursList.push('</div>');
        }
        document.getElementById('masseurs').innerHTML = masseursList.join(''); //innerHTMLへ入れる時にjoin()で文字列にする
    </script>

</body>

</html>
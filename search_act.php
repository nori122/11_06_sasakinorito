<!---------------------
     php 要素
--------------------->
<?PHP
session_start();
include("functions.php");
check_session_id();

// var_dump($_POST);
// exit();

//チェックボックスで選択したメニューをfiltered_menuに代入
$filtered_menu = implode(",", $_POST["menu"]);
$min_price = $_POST["min_price"];
$max_price = $_POST["max_price"];

// DB接続
$pdo = connect_to_db();



//DBの結合（services_tableとmasseurs_table)と、検索
$sql = 'SELECT * FROM `services_table` LEFT OUTER JOIN `masseurs_table` ON in_charge = masseur_id WHERE item=:filtered_menu AND :min_price<price AND price<:max_price';

// SQL準備
$stmt = $pdo->prepare($sql);

//bind
$stmt->bindValue(':filtered_menu', $filtered_menu, PDO::PARAM_STR);
$stmt->bindParam(':min_price', $min_price, PDO::PARAM_INT);
$stmt->bindParam(':max_price', $max_price, PDO::PARAM_INT);

//実行
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
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["item"]}</td>";
        $output .= "<td>{$record["duration"]}</td>";
        $output .= "<td>{$record["price"]}</td>";
        $output .= "<td>{$record["in_charge"]}</td>";
        $output .= "<td>{$record["masseur_name"]}</td>";
        // $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]}</a></td>";
        $output .= "</tr>";
    }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
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

    <title>search act</title>
</head>

<body>
    <div><a href='top.php'><i class="fas fa-home"></i></a><?= $_SESSION['customer_id'] ?>さん </div>

    <!-- 検索条件を表示 -->
    <fieldset class="search_param">
        <legend>検索条件</legend>
        <p>選択メニュー：<?= $filtered_menu ?>マッサージ</p>
        <p>料金：<?= $min_price ?>〜<?= $max_price ?></p>
    </fieldset>


    <div class='result'>
        <table>
            <thead>
                <tr>
                    <th>メニュー</th>
                    <th>時間</th>
                    <th>価格</th>
                    <th>担当者</th>
                </tr>
            </thead>
            <tbody>
                <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
                <?= $output ?>
            </tbody>
        </table>
    </div>

</body>

</html>
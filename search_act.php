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
$filtered_menu = '("' . implode('","', $_POST['menu']) . '")';

// echo ($filtered_menu);
// exit();
$min_price = $_POST["min_price"];
$max_price = $_POST["max_price"];

// DB接続
$pdo = connect_to_db();



//DBの結合（services_tableとmasseurs_table)と、検索
// $sql = 'SELECT * FROM `services_table` LEFT OUTER JOIN `masseurs_table` ON in_charge = masseur_id WHERE item = :filtered_menu AND :min_price<price AND price<:max_price';
$sql = 'SELECT * FROM `services_table` LEFT OUTER JOIN `masseurs_table` ON in_charge = masseur_id WHERE item IN' . $filtered_menu . '  AND :min_price<price AND price<:max_price';
//どれかに一致したときにwhereするsql文
//→🎉できた🎉 INを使うのはすぐわかったが、implodeの前後にかっこをつけるのでてこずった。bindすると文字コードが意図せぬ挙動をする。

//人ごとに別の配列を作って、phpでそこに入れ直して、扱う


// SQL準備
$stmt = $pdo->prepare($sql);

//bind
// $stmt->bindValue(':filtered_menu', $filtered_menu, PDO::PARAM_STR);
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
    // $bymasseurs = [];
    // foreach ($result as $item) {
    //     $key = $item['masseur_name'];
    //     if (array_key_exists($key, $bymasseurs)) {
    //         $bymasseurs[$key][] = $item;
    //     } else {
    //         $bymasseurs[$key] = [$item];
    //     }
    // }
    // echo ('<pre>');
    // var_dump($bymasseurs);
    // echo ('</pre>');

    // 検索結果をjavascriptで扱うため、json形式にする
    // $php_bymasseurs = json_encode($bymasseurs);
    $php_result = json_encode($result);
}

// $output = "";
// <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
// `.=`は後ろに文字列を追加する，の意味
// foreach ($result as $record) {
//     $output .= "<tr>";
//     $output .= "<td>{$record["item"]}</td>";
//     $output .= "<td>{$record["duration"]} 分</td>";
//     $output .= "<td>{$record["price"]}</td>";
//     $output .= "<td>{$record["masseur_name"]}</td>";
//     // $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]}</a></td>";
//     $output .= "</tr>";
// }
// $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
// 今回は以降foreachしないので影響なし
//     unset($value);
// }


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
    <div><a href='top.php'><i class="fas fa-home"></i></a><?= $_SESSION['customer_name'] ?>さん </div>

    <!-- 検索条件を表示 -->
    <fieldset class="search_param">
        <legend>検索条件</legend>
        <p>選択メニュー：<?= $filtered_menu ?></p>
        <p>料金：<?= $min_price ?>〜<?= $max_price ?></p>
    </fieldset>


    <div id="result" class='result'>
    </div>




    <!---------------------
    javascript 要素
    --------------------->
    <script>
        //phpからマッサージ師リストの配列を取得しjs_bymasseursに代入する
        let js_result = <?php echo $php_result; ?>;
        console.log(js_result);
        // console.log(js_result['ノリト'][0]['masseur_name']);
        var by_masseur = {};
        js_result.map((i) => {
            var name = i["masseur_name"];
            if (typeof by_masseur[name] == "undefined") by_masseur[name] = [];
            by_masseur[name].push(i);
        });
        console.log(by_masseur);

        var mapped_masseur = {};
        mapped_masseur = Object.entries(by_masseur);
        // console.log(mapped_masseur);
        // console.log(mapped_masseur.length);
        // console.log(mapped_masseur[0][0]); //ノリト
        // console.log(mapped_masseur[0][1][0]['masseur_comment']); //
        // console.log(mapped_masseur[0][1].length);


        // js_bymasseursからHTMLタグを含むresultCardsを作成する
        let resultCards = [];
        for (var i = 0; i < mapped_masseur.length; i++) {
            resultCards.push('<div class="card">');
            resultCards.push('<img src="img/seitaishi_man.png" alt="整体師" class="masseurImg">');
            resultCards.push('<div class="cardText">');
            resultCards.push('<div>マッサージ師：' + (mapped_masseur[i][1][0]['masseur_name']) + '</div>');
            resultCards.push('<div>レビュー評価：' + (mapped_masseur[i][1][0]['masseur_rate']) + '</div>');
            resultCards.push('<div>勤務サロン：' + mapped_masseur[i][1][0]['masseur_salon'] + '</div>');
            resultCards.push('<div>コメント：' + mapped_masseur[i][1][0]['masseur_comment'] + '</div><br>');
            resultCards.push('<table><thead>');
            resultCards.push('<th>メニュー</th> <th> 時間 </th> <th> 価格 </th></thead>');
            resultCards.push('<tbody style="color:red;">');
            for (var j = 0; j < mapped_masseur[i][1].length; j++) {
                resultCards.push('<tr>');
                resultCards.push('<td>' + (mapped_masseur[i][1][j]['item']) + 'マッサージ</td>');
                resultCards.push('<td>' + (mapped_masseur[i][1][j]['duration']) + '分</td>');
                resultCards.push('<td>' + (mapped_masseur[i][1][j]['price']) + '円</td>');
                resultCards.push('</tr>');
            }
            resultCards.push('</tbody>');
            resultCards.push('</table>');
            resultCards.push('</div>');
            resultCards.push('</div>');
        }
        document.getElementById('result').innerHTML = resultCards.join(''); //innerHTMLへ入れる時にjoin()で文字列にする
    </script>

</body>

</html>
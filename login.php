<!---------------------
     php 要素
--------------------->



<?PHP




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

    <title>Sabai</title>
</head>

<body>

    <form action="login_act.php" method="POST">
        <fieldset>
            <legend>ログイン画面</legend>
            <div>
                customer_id: <input type="text" name="customer_id">
            </div>
            <div>
                password: <input type="text" name="customer_password">
            </div>
            <div>
                <button>Login</button>
            </div>
            <a href="register.php">or register</a>
        </fieldset>
    </form>


</body>

</html>
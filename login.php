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
                customer_id: <input type="text" name="customer_id" autocomplete="off">
            </div>
            <div>
                password: <input type="password" name="customer_password" autocomplete="off">
            </div>
            <div>
                <button>Login</button>
            </div>
            <a href="register/register.php">or register</a>
        </fieldset>
    </form>


</body>

</html>
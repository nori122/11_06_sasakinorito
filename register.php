<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>todoリストユーザ登録画面</title>
</head>

<body>
  <form action="register_act.php" method="POST">
    <fieldset>
      <legend>todoリストユーザ登録画面</legend>
      <div>
        customer_name: <input type="text" name="customer_name" autocomplete="off">
      </div>
      <div>
        customer_id: <input type="text" name="customer_id" autocomplete="off">
      </div>
      <div>
        password: <input type="password" name="customer_password" autocomplete="off">
      </div>
      <div>
        <button>Register</button>
      </div>
      <a href="login.php">or login</a>
    </fieldset>
  </form>

</body>

</html>
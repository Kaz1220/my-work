<?php
session_start();
$dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
$user = "root";
$password = "root";
$dbInfo=new PDO($dsn,$user,$password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  /* nameとpassとrepassが定義されて、かつ空白ではない */
  if (isset($_POST['name'], $_POST['pass'], $_POST['repass']) && $_POST['name'] !== '' && $_POST['pass'] !== ''&& $_POST['repass'] !== '')  {
    try {
      $dbInfo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT); // エラーを出力できるように設定
    } catch (PDOException $e) {
      $_SESSION['register_message'] = 'データベース接続に失敗しました';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }

    /* 重複チェック */
    $stmt = $dbInfo->prepare('SELECT * FROM login WHERE name=:name');
    $stmt->bindValue(":name", $_POST['name']);
    $stmt->execute();
    if (count($stmt->fetchAll())) {
      $_SESSION['register_message'] = 'このユーザーネームはすでに使われています';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }

    /* パスワード確認 */
    if ($_POST['pass'] !== $_POST['repass']) {
      $_SESSION['register_message'] = 'パスワードを正しく入力してください';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }

    /* データ挿入 */
    $stmt = $dbInfo->prepare('INSERT INTO login (name, pass) VALUES (:name,:pass)');
    $stmt->bindValue(":name", $_POST['name']);
    $stmt->bindValue(":pass", $_POST['pass']);
    $stmt->execute();
    $_SESSION['register_message'] = '会員登録が完了しました';
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['register'] = $_POST['register'];
    header('Location: register-comp.php');
    exit;

  }

  else {
    $_SESSION['register_message'] = '正しく入力して下さい';
    header('Location:'.$_SERVER['PHP_SELF']);
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="KUJIRA Cafe">
  <meta property="og:type" content="website">
  <meta property="og:url" content="ページのURL">
  <meta property="og:image" content="サムネイル画像のURL">
  <meta property="og:site_name" content="KUJIRA Cafe">
  <meta property="og:description" content="ページの簡易説明">
  <title>本気タスク</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="wrapper">
    <header>
      <h1 class="logo"><a href="index.php"><img src="image/main-visual.png" alt=""></a></h1>
    </header>
    <main>
      <h2 class="heading">新規ユーザー登録</h2>
      <form class="loginForm" action"./" method="POST">
        <p class="error"><?php
        if (!empty($_SESSION['register_message'])) {
          echo($_SESSION['register_message']);
        }
        ?></p>
        <label>
          <p>ユーザー名</p>
          <input type="text" class="uname" name="name">
        </label>
        <label>
          <p>パスワード</p>
          <input type="password" class="passwd" name="pass">
        </label>
        <label>
          <p>パスワード（確認）</p>
          <input type="password" class="repasswd" name="repass">
        </label>
        <input type="hidden" name="register" value="0">
        <div class="button">
          <input type="button" class="return btn" value="戻る" onClick="location.href='index.php'">
          <input type="submit" class="login btn" value="登録">
        </div>
      </form>
    </main>
    <footer>
      <h2 class="description"><a href="description.html">このサイトについて</a></h2>
    </footer>
  </div>
  <script src="js/main.js"></script>
</body>
</html>
<?php
$_SESSION['register_message'] = '';
?>

<?php
session_start();
$dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
$user = "root";
$password = "root";
$dbInfo=new PDO($dsn,$user,$password);

if (isset($_SESSION['name'])) {
  header('location: mypage.php');
  exit;
}

/* POSTで送信されている */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  /* usernameとpasswordが定義されて、かつ空白ではない */
  if (isset($_POST['name'], $_POST['pass']) && $_POST['name'] !== '' && $_POST['pass'] !== '')  {
    /* データベース接続 */
    try {
      $dbInfo=new PDO($dsn,$user,$password);
      $dbInfo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT); // エラーを出力できるように設定
    } catch (PDOException $e) {
      //echo $e->getMessage();
      $_SESSION['login_message'] = 'データベース接続に失敗しました';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }

    /* ユーザー認証 */
    $stmt = $dbInfo->prepare('SELECT * FROM login WHERE name=:name AND pass=:pass');
    $stmt->bindValue(":name", $_POST['name']);
    $stmt->bindValue(":pass", $_POST['pass']);
    $stmt->execute();

    $result = $stmt->fetchAll();
    if (count($result) === 1) {
      $_SESSION['name'] = $_POST['name'];

      $_SESSION['uid'] = $result[0]["uid"]; //uid取得

      header('Location: mypage.php');
      exit;
    }else {
      $_SESSION['login_message'] = 'ユーザー名またはパスワードが正しくありません';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }
  }else {

  /* 正しくログインできなかった */
  $_SESSION['login_message'] = '入力データが正しくありません';
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
      <h2 class="heading">“本気”のあなたを応援したい。</h2>
      <form class="loginForm" action"./" method="POST">
        <p class="error"><?php
          if (!empty($_SESSION['login_message'])) {
            echo($_SESSION['login_message']);
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
        <input type="submit" class="login btn" value="ログイン">
      </form>
      <div class="registerArea">
        <a href="register.php" class="register">アカウントをお持ちでない方はこちら</a>
      </div>
    </main>
    <footer>
      <h2 class="description"><a href="description.html">このサイトについて</a></h2>
    </footer>
  </div>
</body>
</html>
<?php
/* セッションの初期化 */
$_SESSION['login_message'] = '';
?>

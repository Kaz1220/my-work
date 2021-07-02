<?php
session_start();
$dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
$user = "root";
$password = "root";
$dbInfo=new PDO($dsn,$user,$password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['name'], $_POST['pass'], $_POST['repass']) && $_POST['name'] !== '' && $_POST['pass'] !== ''&& $_POST['repass'] !== '')  {
    try {
      $dbInfo=new PDO($dsn,$user,$password);
      $dbInfo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    } catch (PDOException $e) {
      //echo $e->getMessage();
      $_SESSION['unsub_message'] = 'データベース接続に失敗しました';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }

    /* ユーザー認証 */
    $stmt = $dbInfo->prepare('SELECT * FROM login WHERE name=:name AND pass=:pass');
    $stmt->bindValue(":name", $_POST['name']);
    $stmt->bindValue(":pass", $_POST['pass']);
    $stmt->execute();

    $result = $stmt->fetchAll();

    if($_POST['pass'] !== $_POST['repass']){
      $_SESSION['unsub_message'] = 'パスワードを正しく入力してください';
      header('Location:'.$_SERVER['PHP_SELF']);
      exit;
    }

    if (count($result) === 1) {
      $_SESSION['name'] = $_POST['name'];

      $_SESSION['uid'] = $result[0]["uid"]; 
      $_SESSION['unsub'] = $_POST['unsub'];
      header('Location: unsub-comp.php');
      exit;
    }else {
        $_SESSION['unsub_message'] = 'ユーザー名またはパスワードが正しくありません';
        header('Location:'.$_SERVER['PHP_SELF']);
        exit;
      }
    }else {
    /* 正しくログインできなかった */
    $_SESSION['unsub_message'] = '入力データが正しくありません';
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
  <meta property="og:title" content="本気タスク">
  <meta property="og:type" content="website">
  <meta property="og:url" content="ページのURL">
  <meta property="og:image" content="サムネイル画像のURL">
  <meta property="og:site_name" content="本気タスク">
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
      <h2 class="heading">退会のお手続き</h2>
      <form class="loginForm" action"./" method="POST">
        <p class="error"><?php
          if (!empty($_SESSION['unsub_message'])) {
            echo($_SESSION['unsub_message']);
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
        <input type="hidden" name="unsub" value="0">
        <div class="button">
          <input type="button" class="return btn" value="戻る" onClick="location.href='mypage.php'">
          <input type="submit" class="login btn" value="退会" onClick="location.href='unsub-comp.html'">
        </div>
      </form>
    </main>
    <footer>
      <h2 class="description"><a href="description.html">このサイトについて</a></h2>
    </footer>
  </div>
</body>
</html>
<?php
$_SESSION['unsub_message'] = '';
?>

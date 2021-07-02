<?php
  session_start();
  if(!isset($_SESSION['unsub'])) {
    header('location: unsub.php');
    exit;
  }else {
  $dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
  $user = "root";
  $password = "root";
  $dbInfo=new PDO($dsn,$user,$password);
  $dlt=$dbInfo->prepare('DELETE FROM login WHERE name = :name');
  $dlt->execute(array(':name' => $_SESSION["name"]));
  session_destroy();
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
      <h3 class="registerDone">退会が完了しました。</h3>
      <p class="registerArea">ご利用ありがとうございました。</p>
      <div class="returnTop">
        <a href="index.php">トップページへ戻る</a>
      </div>
    </main>
    <footer>
      <h2 class="description"><a href="description.html">このサイトについて</a></h2>
    </footer>
  </div>
</body>
</html>

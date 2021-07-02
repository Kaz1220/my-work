<?php
  session_start();
  if(!isset($_SESSION['register'])) {
    header('location: index.php');
    exit;
  }else {
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
      <h3 class="registerDone">会員登録が完了しました。</h3>
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

<?php
  session_start();
  if (!isset($_SESSION['ng'])) {
    header('location: index.php');
    exit;
  }else {
    $dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
    $user = "root";
    $password = "root";
    $uid=$_SESSION["uid"];
    $dbInfo=new PDO($dsn,$user,$password);
    $dbInfo->query('SET foreign_key_checks = 0');
    $dlt=$dbInfo->prepare('DELETE login,tasklist FROM login INNER JOIN tasklist ON login.uid = tasklist.uid WHERE login.uid = :uid');
    $dlt->execute(array(':uid' => $uid));
    session_destroy();
    }
  // echo "<pre>".print_r($_SESSION)."</pre>";
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
      <h2 class="heading">お叱りページ</h2>
      <div class="descriptionArea">
        <p>あなたは自分で決めたタスクの期日を守れませんでした。<br>期日を守ることは対人関係においても、仕事においても、社会生活の基本です。<br>約束とは信頼関係の上で成り立つものであり、約束を破れば信用を失います。<br>自分自身の信頼を失っては、これからの約束期限も守れるはずもありません。<br>残念ですが、残りのタスクの破棄と会員登録の抹消となります。
        <p class="sc"><span class="sc1">登録タスクの破棄と会員登録の抹消を実行しました。</span><br>ご利用ありがとうございました。</p>
      </div>
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

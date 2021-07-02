<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
$nowNow=date('Y-m-d');
$n = strtotime('+1 minute');
$nowNow2 = date('H:i', $n);

// echo $nowNow." ".$nowNow2;
// echo "<pre>".print_r($_SESSION)."</pre>";
if (!isset($_SESSION['name'])) {
  header('location: index.php');
  exit;
}

$dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
$user = "root";
$password = "root";
$dbInfo=new PDO($dsn,$user,$password);
$uid=$_SESSION['uid'];
//タスク取得
$sql1="SELECT * FROM tasklist WHERE uid = {$uid}"; 
$stmt1=$dbInfo->query($sql1);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST["task"])) {
    $task=$_POST['task'];
    $date=date("Y/m/d H:i:s");
    $datelimit =$_POST['datelimit'];
    $sql="INSERT INTO tasklist(uid,task,date,datelimit) VALUES (:uid,:task,:date,:datelimit)"; 
    $stmt=$dbInfo->prepare($sql);
    $stmt->bindValue(":uid",$uid,PDO::PARAM_INT);
    $stmt->bindParam(":task",$task,PDO::PARAM_STR);
    $stmt->bindParam(":date",$date);
    $stmt->bindParam(":datelimit",$datelimit);
    $stmt->execute();
    header('location:'.$_SERVER['PHP_SELF']);
  }
}

/* 達成ボタンが押された */

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
  <body>
  <div class="wrapper">
    <header>
      <h1 class="logo"><a href="index.php"><img src="image/main-visual.png" alt=""></a></h1>
    </header>
    <main>
        <h2 class="heading"><?php echo('ようこそ '.$_SESSION['name'].' さん'); ?></h2>
        <!-- タスク入力 -->
      <form class="input-task" action method="POST">
        <input type="text" class="input-box" name="task" placeholder="タスクを入力して下さい" required>
        <div class="inputs">
        <input type="datetime-local" class="input-limit" name="datelimit" min="<?php echo $nowNow.'T'.$nowNow2 ?>" required>
        <input type="submit" class="submit" value="登録">
        </div>
      </form>
      <section class="output-task">
          <?php foreach ($stmt1 as $key => $row): ?>
            <form class='newOutputs' action="delete.php" method="POST" name="outFrom">
              <input type='textarea' class='display-task' placeholder='タスク表示' value='<?php echo $row['task'] ?>'>
              <div class="outFlex">
                <p class="pinline">期日：<span class="pinline" id="limit<?php echo $key ?>"><?php echo $row['datelimit'] ?></span></p>
                  <p class="pinline">残り時間：<span id="RealtimeCountdownArea<?php echo $key ?>">カウントダウン</span></p>
                  <input type="hidden" name="hdatelimit" value="<?php echo $row['datelimit'] ?>">
                  <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                  <input type="submit" class="done" name="done" value="達成"><br>
              </div>
            </form>
            <?php
            if((date('Y-m-d H:i:s'))>=($row['datelimit'])) {
              $_SESSION['ng']=1;
              header('location: scolding.php');
              exit;
            }
            ?>
          <?php endforeach ?>
        </section>
      <form action="logout.php" method="POST">
        <div class="logoutArea">
          <input type="submit" class="logout" value="ログアウト">
        </div>
      </form>
    </main>
    <footer>
      <h2 class="description"><a href="description.html">このサイトについて</a></h2>
      <div class="unsubscrib">
        <input type="hidden" name="logout">
        <input type="submit" class="unsub btn" value="退会する" onClick="location.href='unsub.php'">
      </div>
    </footer>
  </div>
  <!-- スクリプト -->
  <script>
    for(var $x=0;$x<11;$x++) {
      $([id='RealtimeCountdownArea'+$x]) {
        $y=$(this).attr('id');
        $y=$y.substr(21);
        var rcda_val=$(this).val();
      }
    }
    for(var $x=0;$x<11;$x++) {
      $(['id=limit'+$x]){
        $y=$(this).attr('id');
        $y=$y.substr(4);
        var rcda1_val=$(this).val();
      }
    }
  </script>
  <script>
    function showCountdown() {
      try {
      for(var $i=0;$i<11;$i++) {
      var nowDate = new Date();
      var dnumNow = nowDate.getTime();
      var datelimits=document.getElementById('limit'+$i).innerText;

      var targetDate = new Date(datelimits);
      var dnumTarget = targetDate.getTime();
      var diff2Dates = dnumTarget - dnumNow;

      if(diff2Dates>0) {
      var dDays  = diff2Dates / ( 1000 * 60 * 60 * 24 );  // 日数
      diff2Dates = diff2Dates % ( 1000 * 60 * 60 * 24 );
      var dHour  = diff2Dates / ( 1000 * 60 * 60 );   // 時間
      diff2Dates = diff2Dates % ( 1000 * 60 * 60 );
      var dMin   = diff2Dates / ( 1000 * 60 );    // 分
      diff2Dates = diff2Dates % ( 1000 * 60 );
      var dSec   = diff2Dates / 1000; // 秒

      var msg = Math.floor(dDays) + "日"
      + Math.floor(dHour) + "時間"
      + Math.floor(dMin) + "分"
      + Math.floor(dSec) + "秒";
        document.getElementById('RealtimeCountdownArea'+$i).innerText = msg;
      }else {
        var msg2="期日を超えました"
          document.getElementById('RealtimeCountdownArea'+$i).innerText = msg2;
        }
      }
    }catch{}
      }
    setInterval('showCountdown()',1000);
  </script>

</body>
</html>

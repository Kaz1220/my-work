<?php
session_start();
$dsn = "mysql:dbname=task;host=localhost;port=3306;charset=utf8";
$user = "root";
$password = "root";
$dbInfo=new PDO($dsn,$user,$password);
$dlt=$dbInfo->prepare('DELETE FROM tasklist WHERE id =:id');
$dlt->execute(array(':id' => $_POST["id"]));
header('Location: mypage.php');
exit;
?>

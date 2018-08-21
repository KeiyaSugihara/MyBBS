<?php
//sqlからの画像データをバイナリから返還
 $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);

 $id = $_GET['id'];
 $stmt = $dbh->query("select * from articles where id = $id");
 $row = $stmt->fetch();
 header( "Content-Type: ".$row['mime'] );
 echo $row['img'];
?>

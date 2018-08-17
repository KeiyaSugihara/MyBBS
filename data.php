<?php

if (!empty($_POST))
{
    // バイナリデータ
    // $fp = fopen($_FILES["image"]["tmp_name"], "rb");
    // $imgdat = fread($fp, filesize($_FILES["image"]["tmp_name"]));
    // fclose($fp);
    // $imgdat = addslashes($imgdat);
    //
    // // 拡張子
    // $dat = pathinfo($_FILES["image"]["name"]);
    // $extension = $dat['extension'];
    //
    // // MIMEタイプ
    // if ( $extension == "jpg" || $extension == "jpeg" ) $mime = "image/jpeg";
    // else if( $extension == "gif" ) $mime = "image/gif";
    // else if ( $extension == "png" ) $mime = "image/png";
    //
    // // MySQL登録
    // $link = mysql_connect( $url, $user, $pass ) or die("MySQLへの接続に失敗しました。");
    // $sdb = mysql_select_db( $db, $link ) or die("データベースの選択に失敗しました。");
    // $sql = "INSERT INTO `images`.`posts` (`imgdat`, `mime`) VALUES ('".$imgdat."', '".$mime."')";
    //
    // $result = mysql_query( $sql, $link ) or die("クエリの送信に失敗しました。");
    // mysql_close($link) or die("MySQL切断に失敗しました。");
}
?>




<?php


$dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
$stmt = $dbh -> prepare("INSERT INTO articles (name, body, img) VALUES (:name, :body, :img)");
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindValue(':body',$_POST['body']);
$stmt->bindParam(':img', $_POST['img']);
//$name, PDO::PARAM_STR
 //1, PDO::PARAM_INT

$stmt->execute();
$dbh = null;
?>

<html>
<head>
<title>ok</title>
</head>
<body>

<a href = "http://localhost/mybbs/">投稿完了！</a>
</body>

</html>

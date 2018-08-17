<?php


$dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
$stmt = $dbh -> prepare("INSERT INTO reply (name, body, articles_id ,img ) VALUES (:name, :body ,:id,:img )");
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':body',$_POST['body']);
$stmt->bindValue(':id',$_POST['id'], PDO::PARAM_INT);
$stmt->bindParam(':img', $_POST['img']);
$stmt->execute();
$dbh = null;
?>

<html>
<head>
<title>ok</title>
</head>
<body>

<a href = "http://localhost/mybbs/">返信完了！</a>
</body>

</html>

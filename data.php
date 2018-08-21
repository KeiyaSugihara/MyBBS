
<?php

// MySQL登録

$pdo =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$upFile     = $_FILES["image"]["tmp_name"];
$upFileData = file_get_contents($upFile);
$finfo      = finfo_open(FILEINFO_MIME_TYPE);
$mime_type  = finfo_file($finfo, $upFile);
$stmt = $pdo -> prepare("INSERT INTO articles (name, body, img ,mime) VALUES (:name, :body, :img, :mime)");
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':body',$_POST['body']);
$stmt->bindValue(':img', $upFileData, PDO::PARAM_LOB);
$stmt->bindValue(':mime', $mime_type, PDO::PARAM_STR);
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

<?php
// PDOでDBに接続
$dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);

// GETで現在のページ数を取得する（未入力の場合は1を挿入）
if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
} else {
	$page = 1;
}

// スタートのポジションを計算する
if ($page > 1) {
	// 例：２ページ目の場合は、『(2 × 10) - 10 = 10』
	$start = ($page * 10) - 10;
} else {
	$start = 0;
}

// postsテーブルから10件のデータを取得する
$articles = $dbh->prepare("
	SELECT  *
	FROM articles
	LIMIT {$start}, 3
");
$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

foreach ($articles as $post) {
	echo $post['name'];
  echo $post['add_date'];
	echo $post['body'];
}

// postsテーブルのデータ件数を取得する
$page_num = $dbh->prepare("
	SELECT COUNT(*) id
	FROM articles
");
$page_num->execute();
$page_num = $page_num->fetchColumn();

// ページネーションの数を取得する
$pagination = ceil($page_num / 3);

?>

<?php for ($x=1; $x <= $pagination ; $x++) { ?>
	<a href="?page=<?php echo $x ?>"><?php echo $x; ?></a>
<?php } // End of for ?>

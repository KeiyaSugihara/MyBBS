<?php
require_once('method.php');

?>

<!DOCTYPE html>
<html>
  <head>
   <title>MyBBS</title>
   <link rel="stylesheet" type="text/css" href="stylesheet.php">
  </head>
 <body>
   <header>
     <h1>投稿一覧</h1>
   </header>

   <main>

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
       	$start = ($page * 3) - 3;
       } else {
       	$start = 0;
       }



       // postsテーブルから3件のデータを取得する
       $articles = $dbh->prepare("SELECT  *	FROM articles LIMIT {$start}, 3");
       $articles->execute();
       $articles = $articles->fetchAll(PDO::FETCH_ASSOC);?>
          <div class="comentall">
       <?php foreach ($articles as $post): ?>
         <div class="contribution">


          <!-- 記事の表示   -->
        <?php  Method::printdate($post['name'],$post['add_date'],$post['body']); ?>
　　　　　　<!-- 記事に返信 -->
        <?php Method::forms('reply','reply.php',$post['id'],'記事に返信'); ?>
        </div>




            <!-- 返信記事の表示 -->
                <?php foreach ($dbh->query("select distinct(articles_id) from reply") as $row) :?>

                <?php  $hit_number = $row['articles_id'];?>
                <?php if($hit_number == $post['id']):?>
                   <?php $reply_number = $hit_number;?>
                   <?php foreach ($dbh->query("select * from reply where articles_id = $reply_number") as $rep) :?>
                              <div class="replyDate">
                                <?php  Method::printdate($rep['name'],$rep['add_date'],$rep['body']); ?>
                                <!-- コメント返信機能 -->
                                <?php Method::forms('commentReply','commentReply.php',$rep['id'],'コメントに返信'); ?>
                              </div>



                               <div class="replyDatere">
                                   <!-- 再帰関数 -->
                                   <?php Method::recursiveFunction($rep['id']); ?>
                               </div>


                    <?php endforeach ?>
                  <?php endif ?>
                <?php endforeach ?>

         <?php endforeach ?>




      <?php Method::paging(); ?>


　　　<!--投稿機能  -->

       <h2>投稿機能</h2>

        <?php Method::formsimg("tweet","data.php",$formid = null); ?>

      <p></p>


     </div>




   </main>

   <footer>

   </footer>
 </body>
</html>

<?php
require_once('Pagefeature.php');

?>

<!DOCTYPE html>
<html>
  <head>
   <title>MyBBS</title>
   <link rel="stylesheet" type="text/css" href="stylesheet.php">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>

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
       $articles = $dbh->prepare("SELECT * FROM articles LIMIT {$start}, 3");
       $articles->execute();
       $articles = $articles->fetchAll(PDO::FETCH_ASSOC);?>
          <div class="comentall">
       <?php foreach ($articles as $post): ?>
         <div class="contribution">



        <?php  Pagefeature::articles_printdate($post['id'],$post['name'],$post['add_date'],$post['body']); //記事の表示
               Pagefeature::Posted_button('reply','reply.php',$post['id'],'記事に返信'); // 記事に返信?>
             <p class="box"></p>


                <?php foreach ($dbh->query("select distinct(articles_id) from reply") as $row) : //返信記事の表示

                       $hit_number = $row['articles_id'];
                         if($hit_number == $post['id']):
                            $reply_number = $hit_number;
                               foreach ($dbh->query("select * from reply where articles_id = $reply_number") as $rep) :?>
                                 <div class="replyDate">
                                <?php  Pagefeature::reply_printdate($rep['id'],$rep['name'],$rep['add_date'],$rep['body']);
                                 // コメント返信機能
                                 Pagefeature::Posted_button('commentReply','commentReply.php',$rep['id'],'コメントに返信'); ?>
                                  <p class="box"></p>


                               <div class="replyDatere">
                                   <?php Pagefeature::recursiveFunction($rep['id']); //再帰関数 ?>
                               </div>
                                

                             </div>
                    <?php endforeach ?>
                  <?php endif ?>
                <?php endforeach ?>

         <?php endforeach ?>

</div>

      <?php Pagefeature::paging(); //ページング機能 ?>

       <h2>投稿機能</h2>

        <?php Pagefeature::contribution_input("tweet","data.php",$formid = null); //投稿機能 ?>

      <p></p>


     </div>

   </main>

   <footer>

   </footer>
 </body>
</html>

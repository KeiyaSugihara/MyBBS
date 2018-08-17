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
     <div class="tweets">
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
           <div class="nametimedate">

              <span class="name">[<?php echo $post['name'];?>]</span>
              <span>/</span>
              <span class="datatime">[<?php echo $post['add_date']; ?>]</span>
           </div>
            <p></p>
           <div class="texts">[<?php echo $post['body']; ?>]</div>
           <div class="img"><?php print $post['img'] ?></div>
            <p></p>
                  <p>____________________________________</p>
         </div>

            <!-- 返信記事の表示 -->

                <?php foreach ($dbh->query("select distinct(articles_id) from reply") as $row) :?>

                <?php  $hit_number = $row['articles_id'];?>



                <?php if($hit_number == $post['id']):?>
                   <?php $reply_number = $hit_number;?>
                   <?php foreach ($dbh->query("select * from reply where articles_id = $reply_number") as $rep) :?>
                         <div class="replyDate"style="text-indent:em">
                             <div class="replyNameTimedate">
                               <div class="nametimedate">
                                 <span class="name">[<?php echo $rep['name'];?>]</span>
                                 <span>/</span>
                                 <span class="datatime">[<?php echo $rep['add_date']; ?>]</span>
                               </div>
                              <p></p>
                              <div class="texts">[<?php echo $rep['body']; ?>]</div>
                              <p>____________________________________</p>

                              <!-- コメント返信機能 -->
                              <form class="commentreply" action="commentReply.php" method="post">
                              <input type="hidden" name="id"  value="<?php echo $rep['id']; ?>">
                              <input type="submit" value="コメントに返信" >
                              <p></p>
                              </form>
                              </div>
                          </div>


                         <?php  $s = 10 ;?>

                        <?php $repnum = $rep['reply_id']; ?>
                                    <!-- コメント返信表示 -->
                        <?php foreach ($dbh->query("select distinct(reply_id) from reply") as $replyrow) :?>
                        <?php  $hit_replynumber = $replyrow['reply_id'];?>


                          <?php if($hit_replynumber == $repnum):?>
                             <?php $reply_replynumber = $hit_replynumber;?>
                             <?php foreach ($dbh->query("select * from reply where reply_id = $reply_replynumber and id <> reply_id") as $reply) :?>


                                     <?php  $s++ ; ?>
                                     <?php  $s++ ; ?>
                                      <div class="replyDatere">
                                       <!-- <div class="replyNameTimedate">
                                         <div class="nametimedate"> -->
                                           <span class="name">[<?php echo $reply['name'];?>]</span>
                                           <span>/</span>
                                           <span class="datatime">[<?php echo $reply['add_date']; ?>]</span>
                                         <!-- </div> -->
                                        <p></p>
                                        <div class="texts">[<?php echo $reply['body']; ?>]</div>
                                        <p>____________________________________</p>

                                        <!-- コメント返信機能 -->
                                        <form class="commentreply" action="commentReply.php" method="post">
                                        <input type="hidden" name="id"  value="<?php echo $reply['id']; ?>">
                                        <input type="submit" value="コメントに返信" >
                                        <p></p>
                                        </form>

                                    </div>

                                    <?php $repnum = $reply['id'];?>
                              <?php endforeach ?>
                            <?php endif ?>
                          <?php endforeach ?>




                    <?php endforeach ?>
                  <?php endif ?>
                <?php endforeach ?>


                 <form class="reply" action="reply.php" method="post">
                 <input type="hidden" name="id"  value="<?php echo $post['id']; ?>">
                 <input type="submit" value="記事に返信" >
                 </form>
                 <p></p>

      <?php endforeach ?>

    </div>


       <!-- // postsテーブルのデータ件数を取得する -->
      <?php $page_num = $dbh->prepare("
       	SELECT COUNT(*) id
       	FROM articles
       ");
       $page_num->execute();
       $page_num = $page_num->fetchColumn();

       // ページネーションの数を取得する
       $pagination = ceil($page_num / 3);

       ?>
       <div class="posted">
        <a href="?page=<?php echo 1 ?>"> |< </a>
        <?php if($page >= 2):?>
          <a href="?page=<?php echo $page - 1 ?>"> < </a>
        <?php else: ?>
          <a href="?page=<?php echo 1 ?>"> < </a>
        <?php endif ?>
       <?php for ($x=1; $x <= $pagination ; $x++) : ?>

       	<a href="?page=<?php echo $x ?>"><?php echo $x; ?></a>
      <?php  endfor?>
        <a href="?page=<?php echo $page + 1 ?>"> > </a>
        <a href="?page=<?php echo $pagination ?>"> >| </a>
     </div>


　　　<!--投稿機能  -->

       <h2>投稿機能</h2>
        <form class="tweet" action="data.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
          <span style="white-space:nowrap;">
            投稿者
          <input type="text" name="name" style="width:150px";>
          </span>
          <nobr> 本文</nobr>
          <textarea name="body" style="height:100px";></textarea>
          <input type="file" name= "img" >
          <input type="submit" value="投稿" >
        </form>

      <p></p>


     </div>


     </div>

   </main>

   <footer>

   </footer>
 </body>
</html>

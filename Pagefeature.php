

<?php
  class Pagefeature{


    public static function articles_printdate($id, $name, $datatime, $body) {   //投稿データを表示する　画像データを探す際にidがreplyと被るので分けました
       $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
       $stmt = $dbh->query("select * from articles where id = $id");
       $row = $stmt->fetch();

       echo "[$name]&nbsp;/&nbsp;[$datatime]<br><br>";
       echo "[$body]<br><br>";
       if (isset($row['img'])){ ?>
         <a href="<?php echo "create_image.php?id=$id"; ?>" data-lightbox="20171217">
         <?php echo "<img width='20%' src='create_image.php?id=$id'>"; ?>
        </a>
        <?php }
         echo "<br>";
    }

    public static function reply_printdate($id, $name, $datatime, $body) {   //投稿データを表示する　画像データを探す際にidがarticlesと被るので分けました
       $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
       $stmt = $dbh->query("select * from reply where id = $id");
       $row = $stmt->fetch();

       echo "[$name]&nbsp;/&nbsp;[$datatime]<br><br>";
       echo "[$body]<br><br>";
       if (isset($row['img'])) { ?>
         <a href="<?php echo "reply_create_image.php?id=$id"; ?>" data-lightbox="20171217">
         <?php echo "<img width='20%' src='reply_create_image.php?id=$id'>"; ?>
        </a>
        <?php }   
      echo "<br>";
    }



    public static function recursiveFunction($repnum){   //返信を永遠に繰り返しインデントする機能　再帰関数
      $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
                 // コメント返信表示
         foreach ($dbh->query("select * from reply where reply_id = $repnum") as $reply){
             if($reply['reply_id'] == $repnum){ ?>
                    <div class="indexclass">
                  <?php  Pagefeature::reply_printdate($reply['id'],$reply['name'],$reply['add_date'],$reply['body']);
                         Pagefeature::Posted_button('commentReply','commentReply.php',$reply['id'],'コメントに返信'); ?>
                          <p class="box"></p>
                  <?php Pagefeature::recursiveFunction($reply['id']); ?>
                    </div>
          <?php  }else{
               break;
             }
        }
    }



  public static function Posted_button($formclass,$access,$formid,$message){ //投稿ボタン　?>
   <form class="<?php echo $formclass ?>" action="<?php echo $access ?>" method="post">
   <input type="hidden" name="id"  value="<?php echo $formid; ?>">
   <input type="submit" value="<?php echo $message ?>" >
   <p></p>
   </form>
   <?php  }


   public static function contribution_input($formclass,$access,$formid){ // 投稿入力画面 ?>
     <div class="posted">
    <form class="<?php echo $formclass ?>" action="<?php echo $access ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <input type="hidden" name="id"  value="<?php echo $formid; ?>">
    <span style="white-space:nowrap;">
      投稿者
      <input type="text" name="name" style="width:150px";>
      </span>
       本文
      <textarea name="body" style="height:100px";></textarea>
      <input type="file" name= "image" >
      <input type="submit" value="投稿" >
    </form>
    </div>
    <?php  }



    public static function paging(){ //ページング機能
      $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
     // postsテーブルのデータ件数を取得する -->
     $page_num = $dbh->prepare("SELECT COUNT(*) id FROM articles");
     $page_num->execute();
     $page_num = $page_num->fetchColumn();
     // ページネーションの数を取得する
     $pagination = ceil($page_num / 3);

     ?>

      <a href="?page=<?php echo 1 ?>"> |&lt; </a>
      <?php if($page >= 2):?>
        <a href="?page=<?php echo $page - 1 ?>"> &lt; </a>
      <?php else: ?>
        <a href="?page=<?php echo 1 ?>"> &lt; </a>
      <?php endif ?>
     <?php for ($x=1; $x <= $pagination ; $x++) : ?>

      <a href="?page=<?php echo $x ?>"><?php echo $x; ?></a>
     <?php  endfor?>
      <a href="?page=<?php echo $page + 1 ?>"> &gt; </a>
      <a href="?page=<?php echo $pagination ?>"> &gt;| </a>


     <?php  }


}
?>

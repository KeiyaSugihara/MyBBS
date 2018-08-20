

<?php
  class Method{
    public $name;
    public $datatime;
    public $body;
    public $img;


    public function __construct($name, $datatime, $body, $img) {
      $this->name = $name;
      $this->datatime = $datatime;
      $this->body = $body;
      $this->img = $img;
    }

    public static function printdate($name, $datatime, $body) {

       echo '['.$name.']';
       echo ' / ';
       echo '['.$datatime.']'.'<br>'.'<br>';
       echo '['.$body.']'.'<br>'.'<br>';
       // print $post['img'];
       echo  "____________________________________";
    }


    public static function recursiveFunction($repnum){
      $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
                 // コメント返信表示
        $replyrow = $dbh->query("select * from reply where reply_id == $repnum");
             if($replyrow['reply_id'] == $repnum){
               $reply_replynumber = $hit_replynumber;
                  foreach ($replyrow as $reply){

                      Method::recursive($reply);
                      Method::recursiveFunction($reply['id']);

                   }

        }
    }


    public static function recursive($reply){ ?>
      <div class="classnum">
        <?php Method::printdate($reply['name'],$reply['add_date'],$reply['body']); ?>
        <!-- コメント返信機能 -->
        <?php Method::forms('commentReply','commentReply.php',$rep['id'],'コメントに返信'); ?>
      </div>

  <?php   }

  public static function printLog($log)
  {
    echo $log.'<br>';
  }


  public static function forms($formclass,$access,$formid,$message){ ?>
   <form class="<?php echo $formclass ?>" action="<?php echo $access ?>" method="post">
   <input type="hidden" name="id"  value="<?php echo $formid; ?>">
   <input type="submit" value="<?php echo $message ?>" >
   <p></p>
   </form>
   <?php  }


   public static function formsimg($formclass,$access,$formid){ ?>
     <div class="posted">
    <form class="<?php echo $formclass ?>" action="<?php echo $access ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <input type="hidden" name="id"  value="<?php echo $formid; ?>">
    <span style="white-space:nowrap;">
      投稿者
      <input type="text" name="name" style="width:150px";>
      </span>
      <nobr> 本文</nobr>
      <textarea name="body" style="height:100px";></textarea>
      <input type="file" name= "img" >
      <input type="submit" value="投稿" >
    </form>
    </div>
    <?php  }



    public static function paging(){
      $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);
     // postsテーブルのデータ件数を取得する -->
     $page_num = $dbh->prepare("	SELECT COUNT(*) id	FROM articles ");
     $page_num->execute();
     $page_num = $page_num->fetchColumn();
     // ページネーションの数を取得する
     $pagination = ceil($page_num / 3);

     ?>

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


     <?php  }


}
?>

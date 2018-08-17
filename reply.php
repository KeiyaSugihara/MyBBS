


<!DOCTYPE html>
<html>
  <head>
   <title>MyBBS</title>
   <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
 <body>
   <header>
     <h1>選択記事</h1>
   </header>

   <main>
     <div class="tweets">
       <?php
       // PDOでDBに接続
       $dbh =new PDO('mysql:host=localhost;dbname=mybbs;charset=utf8', root, password);

       $idnum = $_POST['id'];


       $stmt = $dbh->query("select * from articles where id = $idnum");
       $select_data = $stmt->fetch();?>



         <div class="nametimedate">
              <span class="name">[<?php echo $select_data['name'];?>]</span>
              <span>/</span>
              <span class="datatime">[<?php echo $select_data['add_date']; ?>]</span>
         </div>
            <p></p>
          <div class="texts">[<?php echo $select_data['body']; ?>]</div>
          <p>____________________________________</p>




     </div>

     <div class="posted">
       <h2>返信機能</h2>
        <form class="tweet" action="replydate.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
          <input type="hidden" name="id"  value="<?php echo $idnum; ?>">
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

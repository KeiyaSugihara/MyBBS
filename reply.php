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
            <?php  Method::printdate($select_data['name'],$select_data['add_date'],$select_data['body']); ?>
         </div>

     </div>

     <div class="posted">
       <h2>返信機能</h2>

          <?php Method::formsimg("tweet","replydate.php",$idnum); ?>

      <p></p>


     </div>


     </div>

   </main>

   <footer>

   </footer>
 </body>
</html>

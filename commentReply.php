<?php
require_once('Pagefeature.php');
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


       $stmt = $dbh->query("select * from reply where id = $idnum");
       $select_data = $stmt->fetch();?>


         <div class="nametimedate">
              <?php  Pagefeature::reply_printdate($select_data['id'],$select_data['name'],$select_data['add_date'],$select_data['body']); ?>
         </div>


     </div>

     <div class="posted">
       <h2>返信機能</h2>

          <?php Pagefeature::contribution_input("tweet","commentReplyDate.php",$idnum); ?>

      <p></p>


     </div>


     </div>

   </main>

   <footer>

   </footer>
 </body>
</html>

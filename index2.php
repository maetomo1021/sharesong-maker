
<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <title>掲示板: A - 新規スレッド</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
  <div class="header0">
    <div class="header00">
      <h1 class="title">掲示板: A </h1>
    </div>
  </div>


<?php
$ThreadTitle_array=array();

try{
  $pdo=new PDO('mysql:host=localhost;dbname=a_data','root','');
} catch (PDOException $e) {
  echo $e->getMessage();
}
  

  $sql="SELECT page_id ,pagename , post_time  FROM `page` WHERE page_id=1;";
  $ThreadTitle_array = $pdo->query($sql);
  
    
  foreach($ThreadTitle_array as $ThreadTitle):  
?>
<div class="ThreadHeader">
  <div class="ThreadHeader1">
    <h3><?php echo $ThreadTitle["pagename"]?></h3>
  </div>
</div>



<?php
endforeach;
$comment_array=array();


  

  $sql="SELECT id ,username , post_time ,comment  FROM `a` WHERE page_id=1;";
  $comment_array = $pdo->query($sql);
  
  

  
 foreach($comment_array as $comment):
  ?>
  <div class="thread">
    <div class="thread1">
    <span class = "id"><?php echo $comment["id" ]?>.</span>
    <span class="username"><?php echo $comment["username"] ?></span><br>
    <span class="post_time"><?php echo $comment["post_time"]; ?></span>
    <br></br>
    <soan class="comment"><?php echo $comment["comment"]; ?></span>
    </div>
  </div><?php
endforeach;

?>

  <!--*入力欄-->
  <form class="post" action="1.php" method="post">
    <div class="post1">
      <p class=name_mail>名前 ＆ メールアドレス</p>
      <?php
      if (isset($_POST["button"])) {
         //表示名の入力チェック
         if (empty($_POST["username1"])) {
           $error_message[1] = "↓お名前を入力してください。↓";
         ?>
         <p class=error_message><?php echo $error_message[1]; ?></p>
         <?php
         }
         ?>
      <input class="input1" placeholder="名前" name=username1>
      <input class="input2" placeholder="メールアドレス(非表示)">
    </div>
      
      <p class=post_comment>投稿内容</p>
      <?php
        //コメントの入力チェック
        if (empty($_POST["comment1"])) {
           $error_message[2] = "↓コメントを入力してください。↓";
           ?><p class=error_message><?php echo $error_message[2]; ?></p>
           <?php
        }
      }
      ?>
    <textarea name="comment1"></textarea>
    <input type="submit" value="投稿" name="button" >
  </form>
  
  <?php
  $current_date = null;
  $message = array();
  $message_array = array();
  $success_message = null;
  $error_message = array();
  $escaped = array();
  $statment = null;
  $res = null;

if (isset($_POST["button"])) {
  
  
  //入力チェック
    if (empty($_POST["username1"])) {
      $error_message[1] = "お名前を入力してください。";
      
  } elseif (empty($_POST["comment1"])) {
      $error_message[2] = "コメントを入力してください。";
      
  } else {
      $escaped[1] = htmlspecialchars($_POST["username1"], ENT_QUOTES, "UTF-8");
      $escaped[2] = htmlspecialchars($_POST["comment1"], ENT_QUOTES, "UTF-8");
  
      //トランザクション開始
      $pdo->beginTransaction();
    
      $id=15;
      $current_date = date("Y-m-d H:i:s");
      try {
      //SQL作成
      $statment = $pdo->prepare("INSERT INTO a (id,username,post_time,comment,page_id) VALUES (:id,:username,:current_date,:comment,1 );");

      $statment->bindvalue(':id', $id, PDO::PARAM_INT);
      $statment->bindvalue(':username', $escaped[1], PDO::PARAM_STR);
      $statment->bindvalue(':comment', $escaped[2], PDO::PARAM_STR);
      $statment->bindvalue(':current_date', $current_date, PDO::PARAM_STR);

      $res = $statment->execute();
      $res = $pdo->commit();
      } catch (Exception $e) {
      //エラーが発生したときはロールバック(処理取り消し)
      $pdo->rollBack();
     //echo $e->getMessage();
     }

  
    
     }
     $statment = null;
  }
}
$pdo=null;
?> 
</div>

  <div class="header2">
  
  </div>
  
  </body>
</html>
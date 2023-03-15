<?php

$comment_array = array();
$pdo = null;
$stmt = null;

//arrayは配列という意味なので、配列で保存する



//DB接続します↓方法
try {
  $pdo = new PDO("mysql:host=localhost;dbname=bbs-yt", "root", "root");
} catch (PDOException $e) {
  echo $e->getMessage();
}

// echo $_POST["username"];
// スーパーグローバル変数

if (!empty($_POST["submitButton"])) {
  // echo $_POST["username"];
  // echo $_POST["submitButton"];
  $postDate = date("Y-m-d H:i:s");

  try {
    $stmt = $pdo->prepare("INSERT INTO `bbs-table` ( `username`, `comment`, `postDate`) VALUES (:useranme, :comment, :postDate);");
    $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
    $stmt->bindParam(':comment', $_POST['comment'], PDO::PARAM_STR);
    $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);

    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}


//DBからコメントデータを取得する。実行するには、$pdo ->query(sql文)
$sql = "SELECT `id` , `username` , `comment`, `postDate` FROM `bbs-table`; ";
$comment_array = $pdo->query($sql);
//最終的にDB接続を閉じる必要がある為↓を実行する
$pdo = null; ?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <h1 class="borderWrapper">PHPで掲示板アプリ</h1>
  <hr>

  <div class="boardWrapper">
    <section>
      <?php foreach ($comment_array as $comment) : ?>
        <article>

          <div class="wrapper">
            <div class="nameArea">
              <span>名前：</span>
              <p class="username"><?php echo $comment["username"] ?></p>
              <time><?php echo $comment["postDate"] ?></time>
            </div>
            <p class="comment">test投稿です。<?php echo $comment["comment"] ?></p>

          </div>
        </article>
      <?php endforeach; ?>
    </section>

    <form class="formWrapper" method="POST">
      <div>
        <input type="submit" value="登録" name="submitButton">
        <label for="">名前：</label>
        <input type="text" name="username">
      </div>

      <div>
        <textarea class="commentTextArea" name="comment"></textarea>
      </div>

    </form>
  </div>
</body>

</html>





<!-- http://localhost/hal/project1/sharesong-maker/ -->
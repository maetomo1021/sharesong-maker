<?php

$comment_array = array();
//arrayは配列という意味なので、配列で保存する

// echo $_POST["username"];
// スーパーグローバル変数

if (!empty($_POST["submitButton"])) {
  echo $_POST["username"];
  echo $_POST["submitButton"];
}
//DB接続します↓方法
try {
  $pdo = new PDO("mysql:host=localhost;dbname=bbs-yt", "root", "root");
} catch (PDOException $e) {
  echo $e->getMessage();
}

//DBからコメントデータを取得する。実行するには、$pdo ->query(sql文)
$sql = "SELECT `id` , `username` , `comment`, `postDate` FROM `bbs-table`; ";
$comment_array = $pdo->query($sql);
//最終的にDB接続を閉じる必要がある為↓を実行する
$pdo = null;

?>

<!DOCTYPE html>
<html lang="en">

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
              <time>2022/7/15</time>
            </div>
            <p class="comment">手書きコメントです。</p>

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
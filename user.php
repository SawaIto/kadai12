<?php
//0. SESSION開始！！
session_start();

//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();
//２．データ登録SQL作成
$sql = "SELECT * FROM sawa_an_table09";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

//３．データ表示
$values = "";
if ($status == false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values, JSON_UNESCAPED_UNICODE);
//JSONに値を渡す場合に使う
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アンケートフォーム</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

  <?php include 'header.php'; ?>

<!-- Main[Start] -->
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">
<form method="post" action="user_insert.php" class="max-w-md mx-auto mt-20 px-10 py-8 mb-4  bg-white rounded-lg shadow-md">
  <div>
    <fieldset>
      <legend class="text-lg font-bold mb-4">ユーザー登録</legend>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="name">
          名前：
        </label>
        <input class="border border-blue-500 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" type="text" name="name">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="lid">
          Login ID：
        </label>
        <input class="border border-blue-500 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lid" type="text" name="lid">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="lpw">
          Login PW
        </label>
        <input class="w-full border border-blue-500 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lpw" type="text" name="lpw">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="kanri_flg">
          管理FLG：
        </label>
        <div class="flex items-center">
          <label class="inline-flex items-center mr-4">
            <input type="radio" class="form-radio" name="kanri_flg" value="0">
            <span class="ml-2">一般</span>
          </label>
          <label class="inline-flex items-center">
            <input type="radio" class="form-radio" name="kanri_flg" value="1">
            <span class="ml-2">管理者</span>
          </label>
        </div>
      </div>
      <div class="flex justify-end">
        <input type="submit" value="送信" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
      </div>
    </fieldset>
  </div>
</form>
</body>
<footer class="w-full mt-auto">
        <?php include 'footer.php'; ?>
    </footer>
</html>

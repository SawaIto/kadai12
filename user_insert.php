<?php
session_start();
include("funcs.php");
sschk();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name");
    $lid = filter_input(INPUT_POST, "lid");
    $lpw = filter_input(INPUT_POST, "lpw");
    $kanri_flg = filter_input(INPUT_POST, "kanri_flg");

    $lpw = password_hash($lpw, PASSWORD_DEFAULT); //パスワードハッシュ化

    //2. DB接続します
    $pdo = db_conn();

    //３．データ登録SQL作成
    $sql = "INSERT INTO users (name, lid, lpw, kanri_flg, life_flg) VALUES (:name, :lid, :lpw, :kanri_flg, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
    $stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);
    $status = $stmt->execute();

    //４．データ登録処理後
    if ($status == false) {
        sql_error($stmt);
    } else {
        redirect("user_list.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>ユーザー登録</title>
</head>
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">
    <?php include 'header.php'; ?>
    <form method="post" action="user_insert.php" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 md:mt-20 mt-40">
        <div>
            <fieldset>
            <legend class="text-lg font-bold mb-4">ユーザー登録</legend>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="name">名前：</label>
                    <input class="border border-blue-500 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" type="text" name="name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="lid">Login ID：</label>
                    <input class="border border-blue-500 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lid" type="text" name="lid" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2" for="lpw">Login PW</label>
                    <input class="w-full border border-blue-500 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" id="lpw" type="password" name="lpw" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2" for="kanri_flg">権限：</label>
                    <div class="flex items-center">
                        <label class="inline-flex items-center mr-4">
                            <input type="radio" class="form-radio" name="kanri_flg" value="0" checked>
                            <span class="ml-2">一般</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="kanri_flg" value="1">
                            <span class="ml-2">管理者</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <input type="submit" value="登録" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </div>
            </fieldset>
        </div>
    </form>
    <footer class="w-full mt-auto">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
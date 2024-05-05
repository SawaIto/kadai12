<?php
session_start(); // セッションを開始
include("funcs.php");

// セッションチェック
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
    header("Location: login.php");
    exit;
}

// POSTリクエストの処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $comment = $_POST["comment"];
    $user_name = $_SESSION["name"];

    // データベース接続
    $pdo = db_conn();

    // スケジュールの登録
    $sql = "INSERT INTO schedules (user_name, date, comment) VALUES (:user_name, :date, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":user_name", $user_name, PDO::PARAM_STR);
    $stmt->bindValue(":date", $date, PDO::PARAM_STR);
    $stmt->bindValue(":comment", $comment, PDO::PARAM_STR);
    $status = $stmt->execute();

    // 登録成功時はselect.phpにリダイレクト、失敗時はエラーメッセージを表示
    if ($status) {
        header("Location: select.php");
        exit;
    } else {
        exit("スケジュールの登録に失敗しました。");
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>スケジュール入力</title>
</head>
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">
<?php include 'header.php'; ?>

    <!-- スケジュール入力フォーム -->
    <form action="input.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-20 w-11/12 md:w-1/2">
        <div>
            <fieldset>
                <legend class="text-lg font-bold mb-4">スケジュール登録</legend>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-bold mb-2">日付:</label>
                    <input type="date" name="date" id="date" class="w-full border border-gray-300 rounded py-2 px-3" required>
                </div>
                <div class="mb-6">
                    <label for="comment" class="block text-gray-700 font-bold mb-2">コメント:</label>
                    <textarea name="comment" id="comment" class="w-full border border-gray-300 rounded py-2 px-3" rows="4" required></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <input type="submit" value="保存" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </div>
            </fieldset>
        </div>
    </form>

    <!-- フッター -->
    <footer class="w-full mt-auto">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
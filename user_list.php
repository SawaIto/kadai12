<?php
session_start();
// funcs.phpの読み込み
include "funcs.php";
// セッションチェック
sschk();
// データベース接続
$pdo = db_conn();
// SQLクエリの作成
$sql = "SELECT name, lid, kanri_flg FROM users WHERE life_flg = 0";
// SQLクエリの実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
// クエリ実行結果の処理
if ($status == false) {
    // エラー処理
    sql_error($stmt);
} else {
    // 結果の取得
    $user_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーリスト</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">

        <?php include 'header.php'; ?>
    <div class="bg-white shadow-md rounded px-4 md:px-8 pt-6 pb-8 mb-4 mt-20 w-11/12 md:w-2/3">
        <legend class="text-lg font-bold mb-4">ユーザー一覧</legend>
        <div class="overflow-x-auto md:overflow-x-visible">
            <table class="min-w-full divide-y divide-blue-200 border border-blue-300 rounded-md">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">名前</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">LoginID</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">管理者フラグ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-200">
                    <?php foreach ($user_list as $user) : ?>
                        <tr>
                            <td class="px-4 md:px-6 py-4 whitespace-normal text-sm md:text-base font-bold"><?= $user['name'] ?></td>
                            <td class="px-4 md:px-6 py-4 whitespace-normal text-sm md:text-base font-bold"><?= $user['lid'] ?></td>
                            <td class="px-4 md:px-6 py-4 whitespace-normal text-sm md:text-base font-bold">
                                <?= $user['kanri_flg'] == 1 ? "管理者" : "一般" ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="w-full mt-auto">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
<?php
session_start();
include("funcs.php");
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
    header("Location: login.php");
    exit;
}
$pdo = db_conn();
$sql = "SELECT * FROM schedules ORDER BY date ASC"; // ここを修正
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
if ($status) {
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    exit("スケジュールの取得に失敗しました。");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>スケジュール一覧</title>
</head>
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">
    <?php include 'header.php'; ?>
    <div class="bg-white shadow-md rounded px-4 md:px-8 pt-6 pb-8 mb-4 mt-20 w-11/12 md:w-2/3">
    <legend class="text-lg font-bold mb-4">スケジュール一覧</legend>
        <div class="overflow-x-auto md:overflow-x-visible">
            <table class="min-w-full divide-y divide-blue-200 border border-blue-300 rounded-md">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-2 md:px-4 py-2 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">日付</th>
                        <th class="px-2 md:px-4 py-2 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">予定</th>
                        <th class="px-2 md:px-4 py-2 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">入力者</th>
                        <?php if ($_SESSION["kanri_flg"] == 1) : ?>
                            <th class="px-4 md:px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">操作</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-200">
                    <?php foreach ($schedules as $schedule) : ?>
                        <tr>
                            <td class="px-2 md:px-4 py-2 whitespace-normal text-sm md:text-base font-bold"><?= $schedule["date"] ?></td>
                            <td class="px-2 md:px-4 py-2 whitespace-normal text-sm md:text-base font-bold"><?= $schedule["comment"] ?></td>
                            <td class="px-2 md:px-4 py-2 whitespace-normal text-sm md:text-base font-bold"><?= $schedule["user_name"] ?></td>
                            <?php if ($_SESSION["kanri_flg"] == 1) : ?>
                                <td class="px-2 md:px-2 py-2 flex flex-col md:flex-row">
                                    <a href="detail.php?id=<?= $schedule["id"] ?>" class="py-1 px-1 rounded text-xl mb-2 md:mb-0 md:mr-1">✐</a>
                                    <a href="delete.php?id=<?= $schedule["id"] ?>" class="py-1 px-1 rounded text-lg" onclick="return confirm('本当に削除しますか？')">🗑️</a>
                                </td>
                            <?php endif; ?>
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

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>ログイン</title>
</head>
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">
    <!-- ログインフォーム -->
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 md:mt-20 mt-10">
        <form action="login_act.php" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-2xl font-bold mb-2" for="username">ID:</label>
                <input class="border border-blue-500 rounded-md px-3 py-2 text-gray-700 text-2xl focus:outline-none focus:ring-2 focus:ring-blue-500" id="username" type="text" name="lid" placeholder="ID">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-2xl font-bold mb-2" for="password">PW:</label>
                <input class="border border-blue-500 rounded-md px-3 py-2 text-gray-700 text-2xl focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" type="password" name="lpw" placeholder="Password">
            </div>
            <div class="flex items-center justify-between">
                <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-2xl py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="ログイン">
            </div>
        </form>
        <div class="text-center mt-4">
            <a href="login_sub.php" class="text-blue-500 hover:text-blue-700 text-2xl">正恵さん用ログインページへ</a>
        </div>
    </div>
    <footer class="w-full mt-auto">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
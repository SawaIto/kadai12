<?php
session_start();

$lid = $_POST["lid"]; //lid
$lpw = $_POST["lpw"]; //lpw

//1. DB接続します
include("funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM users WHERE lid=:lid AND life_flg=0");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

//5.該当１レコードがあればSESSIONに値を代入
if($val){
    $pw = password_verify($lpw, $val["lpw"]);
    if($pw){
        //Login成功時
        $_SESSION["chk_ssid"] = session_id();
        $_SESSION["kanri_flg"] = $val['kanri_flg'];
        $_SESSION["name"] = $val['name'];
        //Login成功時（select.phpへ）
        redirect("select.php");
    }else{
        //Login失敗時(login.phpへ)
        echo "<script>alert('IDもしくはパスワードが間違っています。再度ご確認ください。'); window.location.href = 'login.php';</script>";
        exit();
    }
}else{
    //該当データなし
    echo "<script>alert('ユーザー登録がありません。管理者に連絡してください。'); window.location.href = 'login.php';</script>";
    exit();
}
exit();
?>
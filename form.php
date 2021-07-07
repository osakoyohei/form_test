<?php

$errmessage = array();

try {
    //データベース接続
    $db = new PDO("mysql:dbname=php_form;host=localhost;charset=utf8mb4","root","root");

    if (isset($_POST['submit'])) {
        if (isset($_POST['user_name'])) {
            $user_name = $_POST['user_name'];
            if ($user_name === '') {
                $errmessage[] = '名前を入力してください';
            }
        }
        
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if ($email === '') {
                $errmessage[] = 'メールアドレスを入力してください';
            }
        }
        if (isset($_POST['message'])) {
            $message = $_POST['message'];
            if ($message === '') {
                $errmessage[] = 'お問い合わせを入力してください';
            }
        }
    
        if (count($errmessage) === 0) {
            $sql = 'insert into form(user_name, email, message, created_at, updated_at) values(?, ?, ?, now(), now())';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
            $stmt->bindValue(2, $email,     PDO::PARAM_STR);
            $stmt->bindValue(3, $message,   PDO::PARAM_STR);
            $stmt->execute();
            $errmessage[] = '送信しました';
        }
    }

} catch (PDOException $e) {
    $errmessage[] = 'DBエラー：' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
</head>
<body>
    <?php foreach($errmessage as $err) { ?>
        <ul>
            <li><?php echo $err; ?></li>
        </ul>
    <?php } ?>

    <form action="form.php" method="post">
        名前<br>
        <input type="text" name="user_name"><br>
        メールアドレス<br>
        <input type="email" name="email"><br>
        お問い合わせ<br>
        <textarea name="message" cols="30" rows="5"></textarea><br>
        <input type="submit" name="submit" value="送信">
    </form>
</body>
</html>
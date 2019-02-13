<?php
//###########################################
// Model　ログイン画面
//###########################################
include ('../module/DBConnect.php');

function handle($params){
    return [
        'page' => 'login',
        'layout' => 'public_default',
        'title' => 'ログイン画面'
    ];
}

//セッションスタート
session_start();

$errorMessage = '';


//ログインボタンが押下された場合
if(isset($_POST["login"])){
    //入力チェック
    if(empty($_POST["email"])){
        $errorMessage = 'メールアドレスを入力してください。';
    }
    if(empty($_POST["password_hash"])){
        $errorMessage = 'パスワードを入力してください';
    }

    //メールの形式のチェック
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $errorMessage = 'メールアドレスの形式が正しくありません。';
    }
    //パスワードの形式チェック
    if(!preg_match("/^[a-zA-Z0-9]+$/", $$_POST["password_hash"])){
        $errorMessage = 'パスワードの形式が正しくありません。';
    }

    if(!empty($_POST["email"]) && !empty($_POST["password_hash"])){
        $email = $_POST["email"];
        $password = $_POST["password_hash"];

        try{
             //データベース接続
            $DB = new DB_Connect();
            $stmt = $DB->prepare('SELECT * FROM Accounts WHERE email = :email');
            $stmt->execute([':name'=>$email]);

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //パスワードのチェック
                if(password_verify($password, $row["password_hash"])){
                    //セッションIDの新規取得
                    session_regenerate_id(true);

                    //セッションにアカウントIDを格納
                    $_SESSION["account_id"] = $row['account_id'];
                    $_SESSION['login'] = true;

                    //ホーム画面へ遷移
                    header("Location: /models/home.php");
                    exit();
                }else{
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            }
        }catch(PDOException $e){
            $errorMessage = 'データベースエラー';
        }
    }
}

?>
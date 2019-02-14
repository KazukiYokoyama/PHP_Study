<?php
//###########################################
// Model　ログイン画面
//###########################################
include ('../module/DBConnect.php');

// セッションの有効期限を1時間に設定
session_set_cookie_params(60 * 60);
//セッションスタート
session_start();

class Login extends Model{
    public function Login(){
        //ログインボタンが押下された場合
        if (isset($_POST["login"])){
            $login_check = new LoginCheck();
            //エラーメッセージが返ってこなければログインの判定を行う
            if(!$login_check->GetErrorMessage()){
                $login_check->LoginDecision();
            }
        }
    } 

    protected $page_data = [
        'page' => 'login',
        'layout' => 'public_default',
        'title' => 'ログイン画面'
    ];
}

/**
 * ログインの判定を行う
 */
class LoginCheck{
    private $email;
    private $password;
    private $errorMessage = [];

    //初期処理
    function __constract(){
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        //入力チェック
        InputCheck();
    }
    
    //入力チェック処理
    public function InputCheck(){
        //入力の有無をチェック
        if(empty($this->email)){
            $errorMessage = 'メールアドレスを入力してください。';
        }
        if(empty($this->password)){
            $errorMessage = 'パスワードを入力してください';
        }
    
        //メールの形式のチェック
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $errorMessage = 'メールアドレスの形式が正しくありません。';
        }
        //パスワードの形式チェック
        if(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $errorMessage = 'パスワードの形式が正しくありません。';
        }
    }

    //DB接続し、ログインの判定を行う
    public function LoginDecision(){
        try{
            //データベース接続
           $DB = new DB_Connect();
           $stmt = $DB->prepare('SELECT * FROM Accounts WHERE email = :email');
           $stmt->execute([':email'=>$this->email]);

           if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               //パスワードのチェック
               if(password_verify($this->password, $row["password_hash"])){
                   //セッションIDの新規取得
                   session_regenerate_id(true);

                   //セッションにアカウントIDを格納
                   $_SESSION["account_id"] = $row['account_id'];


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
    //エラーメッセージの取得
    public function GetErrorMessage(){
        return $this->$errorMessage;
    }
}

?>
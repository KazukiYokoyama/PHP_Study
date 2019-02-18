<?php
//###########################################
// Model　ログイン画面
//###########################################
include ('../module/DBConnect.php');

// セッションの有効期限を1時間に設定
session_set_cookie_params(60 * 60);
//セッションスタート
session_start();

/**
 * ログイン画面出力に必要なパラメータの設定する
 * また、ログインの要求があった場合に処理を実行する判断を行う
 */
class Login extends Model{

    protected $page_data = [
        'page' => 'login',
        'layout' => 'public_default',
        'title' => 'ログイン画面',
        'email_errorMessage' => '',
        'password_errorMessage' => '',
        'errorMessage' => ''
    ];

    public function Action(){

        // ログインボタンが押下された場合、ログイン処理を行う
        if (isset($_POST["login"])){
            // 入力チェック
            $login_check = new LoginCheck();
            // エラーメッセージが返ってこなければログインの判定を行う
            list($email_errorMessage, $password_errorMessage, $errorMessage) = $login_check->GetErrorMessage();
            if(!empty($email_errorMessage) && !empty($password_errorMessage) && !empty($errorMessage)){
                $login_check->LoginDecision();
            }else{
                $this->page_data['email_errorMessage'] = $email_errorMessage;
                $this->page_data['password_errorMessage'] = $password_errorMessage;
                $this->page_data['errorMessage'] = $errorMessage;
            }
        }
    } 

}

/**
 * ログインの判定を行う
 */
class LoginCheck{
    private $email;                     // メールアドレス
    private $password;                  // パスワード
    private $email_errorMessage;        // メールアドレスのエラーメッセージ
    private $password_errorMessage;     // パスワードのエラーメッセージ
    private $errorMessage;              //メールアドレス・パスワード以外のエラーメッセージ

    function __construct(){
        // 画面から送信された内容を取得
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        //入力チェック
        $this->InputCheck();
    }
    
    //入力チェック処理
    private function InputCheck(){
        //入力の有無をチェック
        if(empty($this->email)){
            $this->email_errorMessage = '<p>メールアドレスを入力してください</p>';
        }
        if(empty($this->password)){
            $this->password_errorMessage = '<p>パスワードを入力してください</p>';
        }
    
        //メールの形式のチェック
        if(!empty($this->email) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->email_errorMessage = '<p>メールアドレスの形式が正しくありません</p>';
        }
        //パスワードの形式チェック
        if(!empty($this->password) && !preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $this->password_errorMessage = '<p>パスワードの形式が正しくありません</p>';
        }
    }

    //DB接続し、ログインの判定を行う
    public function LoginDecision(){
        try{
            //データベース接続
           $DB = new DB_Connect();
           $pdo = $DB->getPDO();
           $stmt = $pdo->prepare('SELECT * FROM Accounts WHERE email = :email');
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
                    array_push($this->errorMessage, '<p>ユーザーIDあるいはパスワードに誤りがあります</p>');
               }
           }
       }catch(PDOException $e){
            array_push($this->errorMessage, '<p>データベースエラー:'.$e->getMessage().'</p>');
       }
    }
    //エラーメッセージの取得
    public function GetErrorMessage(){
        return array($this->email_errorMessage, $this->password_errorMessage, $this->errorMessage);
    }
}

?>
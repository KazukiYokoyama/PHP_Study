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
        'errorMessage' => ''
    ];

    public function Action(){

        // ログインボタンが押下された場合、ログイン処理を行う
        if (isset($_POST["login"])){
            // 入力チェック
            $login_check = new LoginCheck();
            // エラーメッセージが返ってこなければログインの判定を行う
            $error_msg = $login_check->GetErrorMessage();
            if(count($error_msg) == 0){
                $login_check->LoginDecision();
            }else{
                echo 'test';
                $this->page_data['errorMessage'] = $this->CreateErrorMsg($error_msg);
            }

        }
    } 

    private function CreateErrorMsg(array $error_msg){
        $ems = '';
        foreach($error_msg as $em){
            $ems .= '<li>'.$em.'</li>';
        }
        return '<ul>'.$ems.'</ul>';
    }

}

/**
 * ログインの判定を行う
 */
class LoginCheck{
    private $email;                 // メールアドレス
    private $password;              // パスワード
    private $errorMessage = [];     // エラーメッセージ

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
            array_push($this->errorMessage, 'メールアドレスを入力してください');
        }
        if(empty($this->password)){
            array_push($this->errorMessage, 'パスワードを入力してください');
        }
    
        //メールの形式のチェック
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorMessage, 'メールアドレスの形式が正しくありません');
        }
        //パスワードの形式チェック
        if(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            array_push($this->errorMessage, 'パスワードの形式が正しくありません');
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
                    array_push($this->errorMessage, 'ユーザーIDあるいはパスワードに誤りがあります');
               }
           }
       }catch(PDOException $e){
            array_push($this->errorMessage, 'データベースエラー:'.$e->getMessage());
       }
    }
    //エラーメッセージの取得
    public function GetErrorMessage(){
        return $this->errorMessage;
    }
}

?>
<?php
//###########################################
// Model　アカウント登録
//###########################################
include ('../module/DBConnect.php');

class Register extends Model{
    protected $page_data = [
        'page' => 'register',
        'layout' => 'public_default',
        'title' => 'アカウント登録',
        'errorMessage' => ''
    ];

    public function Action(){
        // この中で登録処理を呼び出す
        if (isset($_POST["insert"])){
            
            // 入力チェック
            $input_check = new Account();

            // エラーメッセージがあればそのメッセージを渡す
            $err_msg = $input_check->Get_Errormessage();
            
            
            // var_dump($err_msg);

            // echo "<script>alert('エラー');</script>";
            if(isset($err_msg)){
                echo "<script>alert('$err_msg');</script>";
            }
        }
    }

}

class Account {
    private $username;                  // ユーザ名
    private $email;                     // メールアドレス
    private $password;                  // パスワード
    private $errorMessage;              // エラーメッセージ

    function __construct(){
        // 画面から送信された内容を取得
        $this->username = $_POST['username'];
        if(!isset($this->username)){
            $this->username = '';
        }
        $this->email = $_POST['email'];
        if(!isset($this->email)){
            $this->email = '';
        }
        $this->password = $_POST['password'];
        if(!isset($this->password)){
            $this->password = '';
        }
        $this->Input_check();
    }

    protected function Accounts() {
        // 入力チェック呼び出し
        $Insert_Accounts = new Insert_Accounts();

        // 登録処理


    }

    protected function Insert_Accounts(){
        try{
            //データベース接続
           $DB = new DB_Connect();
           $pdo = $DB->getPDO();
           $stmt = $pdo->prepare('INSERT INTO Accounts (account_name, email, password_hash)VALUES(:account_name, :email, :password_hash)');
           $stmt->execute([':account_name'=>$this->username]);
           $stmt->execute([':email'=>$this->email]);
           $stmt->execute([':password_hash'=>$this->password]);

        }catch(PDOException $e){
            $this->errorMessage = '<p>データベースエラー:'.$e->getMessage().'</p>';
        }
    }

    protected function Input_check() {
        $this->errorMessage="";
        #ユーザ名：未入力チェック
        if(empty($this->username)){
            $this->errorMessage .= 'アカウント名を入力してください。\n';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->username)){
            $this->errorMessage .= 'アカウント名の形式が正しくありません。\n';
        }
        #Ｅメール：未入力チェック
        if(empty($this->email)){
            $this->errorMessage .= 'メールアドレスを入力してください。\n';
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->errorMessage .= 'メールアドレスの形式が正しくありません。\n';
        }
        #パスワード：未入力チェック
        if(empty($this->password)){
            $this->errorMessage .= 'パスワードを入力してください。\n';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $this->errorMessage .= 'パスワードの形式が正しくありません。\n';
        }
    }

    function Get_Errormessage(){
        return $this->errorMessage;
    }
}

?>
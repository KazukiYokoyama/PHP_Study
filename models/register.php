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
            
            if(isset($err_msg)){
                echo "<script>alert('$err_msg');</script>";
            }else{
                $flg = $input->Insert_Accounts();
                
            }
        }
    }

}

class Account {
    private $account_name;              // ユーザ名
    private $email;                     // メールアドレス
    private $password;                  // パスワード
    private $errorMessage;              // エラーメッセージ

    function __construct(){
        // 画面から送信された内容を取得
        $this->account_name = $_POST['account_name'];
        if(!isset($this->account_name)){
            $this->account_name = '';
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

    function Insert_Accounts(){
        try{
            //データベース接続
            $DB = new DB_Connect();
            $pdo = $DB->getPDO();

            // SQL準備
            $stmt = $pdo->prepare('INSERT INTO Accounts (account_name, email, password_hash)VALUES(:account_name, :email, :password_hash)');
            
            // プレースホルダの値をセット
            // ・ＳＱＬインジェクション対策
            // ・パスワードのハッシュ化に対応
            $stmt->bindParam(':account_name',$this->account_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $this->password, PDO::PARAM_STR);

            // ＳＱＬ実行部分
            $check = $stmt->execute();

            if($check){
                alert('ＳＱＬ実行成功');
            }else{
                alert('ＳＱＬ実行失敗');
            }

        }catch(PDOException $e){
            $this->errorMessage = '<p>データベースエラー:'.$e->getMessage().'</p>';
        }
    }

    protected function Input_check() {
        $this->errorMessage="";
        #ユーザ名：未入力チェック
        if(empty($this->account_name)){
            $this->errorMessage .= 'アカウント名を入力してください。\n';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->account_name)){
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
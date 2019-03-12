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
            // 入力チェックの結果を取得する
            $account = new Account();
            $username_message = $account->Get_account_name_errorMessage();
            $email_message = $account->Get_email_errorMessage();
            $password_message = $account->Get_password_errorMessage();
            if($username_message || $email_message || $password_message){
                $this->page_data['username_errorMessage'] = $username_message;
                $this->page_data['email_errorMessage'] = $email_message;
                $this->page_data['password_errorMessage'] = $password_message;
            }else{
                if ($account->Insert_Accounts()){
                    header("Location: /registered");  
                }else{
                    $errormessage = $account->Get_errorMessage();
                    if($erormessage){
                        echo "<script>alert('$erormessage');</script>";
                    }
                }
            }
        }
    }

}

class Account {
    private $account_name;              // ユーザ名
    private $email;                     // メールアドレス
    private $password;                  // パスワード
    private $errorMessage;              // 汎用エラー
    private $account_name_errorMessage; // ユーザ名エラーメッセージ
    private $email_errorMessage;        // メールアドレスエラーメッセージ
    private $password_errorMessage;     // パスワードエラーメッセージ

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
        $rtnFlg = 0;
        try{
            //データベース接続
            $DB = new DB_Connect();
            $pdo = $DB->getPDO();
            // SQL準備
            $stmt = $pdo->prepare('INSERT INTO Accounts (account_name, email, password_hash)VALUES(:account_name, :email, :password_hash)');
            // プレースホルダの値をセット
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(':account_name',$this->account_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);
            // ＳＱＬ実行部分
            $check = $stmt->execute();
            if($check){
                echo "<script>alert('アカウントの登録に成功しました！');</script>";
                $rtnFlg = 1;
            }
        }catch(PDOException $e){
            error_log("[". date('Y-m-d H:i:s') . "]アカウント登録エラー：".addslashes($e->getMessage())."\n", 3, "/var/log/php/php_error.log");
            $this->errorMessage = 'アカウントの登録に失敗しました。\nサイトの管理者に連絡してください。';
            $rtnFlg = 0;
        }
        return $rtnFlg;
    }

    private function Input_check() {
        #ユーザ名：未入力チェック
        if(empty($this->account_name)){
            $this->account_name_errorMessage .= '<p>アカウント名を入力してください。</p>';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->account_name)){
            $this->account_name_errorMessage .= '<p>アカウント名は英数字のみで作成してください。</p>';
        }elseif(strlen($this->account_name)> 20){
            $this->account_name_errorMessage .= '<p>アカウント名は２０文字以下で作成してください。</p>';
        }
        #Ｅメール：未入力チェック
        if(empty($this->email)){
            $this->email_errorMessage .= '<p>メールアドレスを入力してください。</p>';
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->email_errorMessage .= '<p>メールアドレスの形式が正しくありません。</p>';
        }
        #パスワード：未入力チェック
        if(empty($this->password)){
            $this->password_errorMessage .= '<p>パスワードを入力してください。</p>';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $this->password_errorMessage .= '<p>パスワードは半角英数字のみで作成してください。</p>';
        }elseif(strlen($this->password)> 20){
            $this->password_errorMessage .= '<p>パスワードは２０文字以下で作成してください。</p>';
        }
    }
    function Get_errorMessage(){
        return $this->errorMessage;
    }
    function Get_account_name_errorMessage(){
        return $this->account_name_errorMessage;
    }
    function Get_email_errorMessage(){
        return $this->email_errorMessage;
    }
    function Get_password_errorMessage(){
        return $this->password_errorMessage;
    }
}

?>

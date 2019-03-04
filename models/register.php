<?php
//###########################################
// Model　アカウント登録
//###########################################
include ('../module/DBConnect.php');

function Err_Alert($str){
    echo "<script>alert('$str');</script>";
}

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
            Err_Alert('テスト開始');
            // 入力チェック
            $input_check = new Account();
            
            // エラーメッセージがあればそのメッセージを渡す
            // エラーメッセージは該当項目の下部に出力する形式に修正すること。
            // パスワードのハッシュ化について、キーは共通化するために確認すること。
            $err_msg = $input_check->Get_Errormessage();

            if($err_msg){
                Err_Alert($err_msg);
            }else{
                $flg = $input_check->Insert_Accounts();
            }
            Err_Alert('テスト終了');
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
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':account_name',$this->account_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);

            // ＳＱＬ実行部分
            $check = $stmt->execute();

            if($check){
                Err_Alert('ＳＱＬ実行成功');
            }else{
                Err_Alert('ＳＱＬ実行失敗');
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
            $this->errorMessage .= 'アカウント名は英数字のみで作成してください。\n';
        }elseif(strlen($this->account_name)> 20){
            $this->errorMessage .= 'アカウント名は２０文字以下で作成してください。\n';
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
            $this->errorMessage .= 'パスワードは半角英数字のみで作成してください。\n';
        }elseif(strlen($this->password)> 20){
            $this->errorMessage .= 'パスワードは２０文字以下で作成してください。\n';
        }
    }

    function Get_Errormessage(){
        return $this->errorMessage;
    }

}

?>
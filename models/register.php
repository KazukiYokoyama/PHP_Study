<?php
//###########################################
// Model　アカウント登録
//###########################################

class Register extends Model{
    protected $page_data = [
        'page' => 'register',
        'layout' => 'public_default',
        'title' => 'アカウント登録'
    ];

    /**
     * アカウント登録画面の動作
     * @return void
     */
    public function Action(){
        $action_request = array_shift($this->url);
        $form = new RegisterForm();

        // アカウント登録要求
        if($action_request === 'sygnup'){
            $AccountRegister = new AccountRegister($form);
            $result = $AccountRegister->getResult();
            // APIレスポンス返却
            echo json_encode($result);
            exit;
        }

    }
}

/**
 * アカウント登録フォームの要素
 */
class RegisterForm{
    private $account_name;              // アカウント名
    private $email;                     // メールアドレス
    private $password;                  // パスワード
    private $vaildation_warning = [];   // 入力チェック違反の警告

    function __construct(){
        // POST内容の取得
        $this->account_name = PF($_POST['account_name']);
        $this->email = PF($_POST['email']);
        $this->password = PF($_POST['password']);

        // 入力チェック
        $this->validationEmail();
        $this->validationPassword();
        $this->validationAccountName();
    }

    /**
     * アカウント名　入力チェック
     * @return void
     */
    private function validationAccountName(){
        if(empty($this->account_name)){
            $this->vaildation_warning['account_name'] = 'アカウント名の入力がありません';
        }elseif(mb_strlen($this->account_name) > 20){
            $this->vaildation_warning['account_name'] = 'アカウント名は20文字以内で入力してください';
        }
    }

    /**
     * メールアドレス　入力チェック
     * @return void
     */
    private function validationEmail(){
        if(empty($this->email)){
            $this->vaildation_warning['email'] = 'メールアドレスの入力がありません';
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->vaildation_warning['email'] = 'メールアドレスの形式が正しくありません';
        }
    }

    /**
     * パスワード　入力チェック
     * @return void
     */
    private function validationPassword(){
        if(empty($this->password)){
            $this->vaildation_warning['password'] = 'パスワードの入力がありません';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $this->vaildation_warning['password'] = 'パスワードの形式が正しくありません';
        }elseif(mb_strlen($this->password) > 20){
            $this->vaildation_warning['password'] = 'パスワードは20文字以内で入力してください';
        }
    }

    public function getAccountName(){
        return $this->account_name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getValidationWarning(){
        return $this->vaildation_warning;
    }
}

/**
 * アカウントの登録を行う
 */
class AccountRegister{
    private $account_name;
    private $email;         // メールアドレス
    private $password;      // パスワード
    private $result = [];   // API実行結果

    function __construct(RegisterForm $form){
        // フォームの入力内容を取得
        $this->account_name = $form->getAccountName();
        $this->email = $form->getEmail();
        $this->password = $form->getPassword();

        // 入力チェック違反の内容を取得
        $this->result['Alert']['Warning'] = $form->getValidationWarning();

        // 入力違反が無ければ認証判定を行う
        if(!count($this->result['Alert']['Warning'])){
            $this->Register();
        }
    }

    /**
     * アカウント登録処理
     * @return void
     */
    private function Register(){
        $pdo = DB_Connect::getPDO();
        try{
            $stmt = $pdo->prepare('INSERT INTO Accounts (account_name, email, password_hash) VALUES (:account_name, :email, :password_hash)');
            $stmt->execute(
                [
                    ':account_name'=>$this->account_name,
                    ':email'=>$this->email,
                    ':password_hash'=>password_hash($this->password, PASSWORD_DEFAULT)
                ]
            );
            $this->result['Success'] = 1;
        }catch(PDOException $e){
            // エラーログ出力
            error_log("アカウント登録失敗：".$e->getMessage().")", 0);

            if(strpos($e->getMessage(), 'Integrity constraint violation: 1062 Duplicate entry')){
                // UNIQUEカラムに重複する内容を入れようとした場合
                $this->result['Alert']['Warning']['failure'] = '既に登録されているアカウントです';
            }else{
                // 予想外のエラーの場合
                $this->result['Success'] = 0;
            }
        }
    }

    /**
     * API実行結果を返す
     * @return array
     */
    public function getResult() :array{
        return $this->result;
    }
}
?>
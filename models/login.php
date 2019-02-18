<?php
//###########################################
// Model　ログイン画面
//###########################################

class Login extends Model{
    protected $page_data = [
        'page' => 'login',
        'layout' => 'public_default',
        'title' => 'ログイン画面'
    ];

    /**
     * ログイン画面の動作
     */
    public function Action(){
        $action_request = array_shift($this->url);
        $Form = new LoginForm();

        // ログイン認証要求
        if($action_request === 'authentication'){
            $LoginAuthentication = new LoginAuthentication($Form);
            $result = $LoginAuthentication->getResult();
            // APIレスポンス返却
            echo json_encode($result);
            exit;
        }
    }
}

/**
 * ログイン画面の要素
 */
class LoginForm{
    private $email;                     // メールアドレス
    private $password;                  // パスワード
    private $vaildation_warning = [];   // 入力チェック違反の警告

    function __construct(){
        // POST内容の取得
        $this->email = PF($_POST['email']);
        $this->password = PF($_POST['password']);

        // 入力チェック
        $this->validationEmail();
        $this->validationPassword();
    }

    // 入力チェック メールアドレス
    private function validationEmail(){
        if(empty($this->email)){
            $this->vaildation_warning['email'] = 'メールアドレスの入力がありません';
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->vaildation_warning['email'] = 'メールアドレスの形式が正しくありません';
        }
    }

    // 入力チェック パスワード
    private function validationPassword(){
        if(empty($this->password)){
            $this->vaildation_warning['password'] = 'パスワードの入力がありません';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $this->vaildation_warning['password'] = 'パスワードの形式が正しくありません';
        }
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
 * ログインの為の認証をおこなう
 */
class LoginAuthentication{
    private $email;         // メールアドレス
    private $password;      // パスワード
    private $result = [];   // API実行結果

    function __construct(LoginForm $form){
        // フォームの入力内容を取得
        $this->email = $form->getEmail();
        $this->password = $form->getPassword();

        // 入力チェック違反の内容を取得
        $this->result['Alert']['Warning'] = $form->getValidationWarning();

        // 入力チェックで問題が無ければ認証判定を行う
        if(!count($this->result['Alert']['Warning'])){
            $this->Authentication();
        }
    }

    /**
     * ログインフォームから送信されたパラメータによってログイン認証判定を行う
     * 認証成功：$this->result['Success'] === 1;
     */
    private function Authentication(){
        // フォームに入力されたメールアドレスに一致するアカウントを取得する
        $pdo = DB_Connect::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM Accounts WHERE email = :email');
        $stmt->execute([':email'=>$this->email]);
        if($Account = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($this->password, $Account["password_hash"])){
                // パスワードがマッチしている場合
                // セッションにアカウントIDを設定する
                session_regenerate_id(true);
                $_SESSION["account_id"] = $Account['account_id'];
                $this->result['Success'] = 1;
            }
        }
        if(!$this->result['Success']){
            $this->result['Alert']['Warning']['failure'] = 'ユーザーIDあるいはパスワードに誤りがあります';
        }
    }

    /**
     * API実行結果を返す
     */
    public function getResult() :array{
        return $this->result;
    }
}

?>
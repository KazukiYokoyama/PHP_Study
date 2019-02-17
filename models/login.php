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
            $LoginAuthentication->Authentication();
            exit;
        }
    }
}

/**
 * ログイン画面の要素
 */
class LoginForm{
    private $email;     // メールアドレス
    private $password;  // パスワード

    function __construct(){
        if(isset($_POST['email'])){
            $this->email = $_POST['email'];
        }
        if(isset($_POST['password'])){
            $this->password = $_POST['password'];
        }
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
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
        $this->email = $form->getEmail();
        $this->password = $form->getPassword();
    }

    /**
     * 入力チェック
     */
    private function InputCheck(){
        $warning = [];

        //メールアドレスをチェック
        if(empty($this->email)){
            $warning['email'] = 'メールアドレス入力がありません';
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $warning['email'] = 'メールアドレスの形式が正しくありません';
        }

        // パスワードをチェック
        if(empty($this->password)){
            $warning['password'] = 'パスワード入力がありません';
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
            $warning['password'] = 'パスワードの形式が正しくありません';
        }

        $this->result['Alert']['Warning'] = $warning;
    }

    /**
     * ログインフォームから送信されたパラメータによってログイン認証判定を行う
     */
    public function Authentication(){
        // 入力チェック
        $this->InputCheck();

        // 入力チェックで問題が無ければ認証判定を行う
        if(!count($this->result['Alert']['Warning'])){
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
                }else{
                    $this->result['Alert']['Warning']['failure'] = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            }
        }

        echo json_encode($this->result);
        exit;
    }
}

?>
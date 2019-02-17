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

        if($action_request === 'authentication'){
            $Action = new LoginAuthentication($Form);
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
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
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
    private $form;

    function __construct(LoginForm $form){
        $this->form = $form;

        $this->InputCheck();

    }

    /**
     * 入力チェック
     */
    private function InputCheck(){
        $emal = $this->form->getEmail();
        $password = $this->form->getPassword();

        $error_msg = [];
        if(empty($emal)){
            $error_msg['email'] = 'メールアドレス入力なし';
        }

        if(empty($password)){
            $error_msg['password'] = 'パスワード入力なし';
        }
        /**
         * hashをJsonに変更
         */
        echo json_encode(['Alert' => ['Warning' => $error_msg]]);
    }
}

?>
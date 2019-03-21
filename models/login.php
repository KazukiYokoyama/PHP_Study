<?php
//###########################################
// Model　ログイン画面
//###########################################

/**
 * ログイン画面出力に必要なパラメータの設定する
 * また、ログインの要求があった場合に処理を実行する判断を行う
 */
class Login extends Model{

	protected $page_data = [
		'email_errorMessage' => '',
		'password_errorMessage' => '',
		'errorMessage' => '',
		'css' => '<link rel="stylesheet" href="/css/login.css">'
	];

	public function Action(){
		// ログインボタンが押下された場合、ログイン処理を行う
		if (isset($_POST["login"])){
			// 入力チェック
			$login_check = new LoginCheck();
			// エラーメッセージがあればそのメッセージを渡す
			$email_message = $login_check->GetEmailErrorMessage();
			$password_message = $login_check->GetPasswordErrorMessage();
			if($email_message || $password_message){
				$this->page_data['email_errorMessage'] = $email_message;
				$this->page_data['password_errorMessage'] = $password_message;
			}
			// ログイン判定
			$login = $login_check->LoginDecision();
			//ログインに失敗した場合エラーメッセージを渡す
			if(!$login){ $this->page_data['errorMessage'] = $login_check->GetErrorMessage(); }
		}
		$this->page = new Page('ログイン画面', 'login', $this->page_data);
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
		if(!isset($this->email)){
			$this->email = '';
		}
		$this->password = $_POST['password'];
		if(!isset($this->password)){
			$this->password = '';
		}
		//入力チェック
		$this->InputCheck();
	}
	
	//入力チェック処理
	private function InputCheck(){
		//入力の有無をチェック
		if(empty($this->email)){
			$this->email_errorMessage = '<p class="text-error">メールアドレスを入力してください</p>';
		}elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->email_errorMessage = '<p class="text-error">メールアドレスの形式が正しくありません</p>';
		}
		if(empty($this->password)){
			$this->password_errorMessage = '<p class="text-error">パスワードを入力してください</p>';
		}elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->password)){
			$this->password_errorMessage = '<p class="text-error">パスワードの形式が正しくありません</p>';
		}
	}

	//DB接続し、ログインの判定を行う
	public function LoginDecision(){
		try{
			//データベース接続
			$pdo = DB_Connect::getPDO();
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
					header("Location: /home");
					exit();
				}else{
					$this->errorMessage = '<p class="text-danger">ログインエラー：ユーザーIDあるいはパスワードに誤りがあります</p>';
				}
			}
		}catch(PDOException $e){
			$this->errorMessage = '<p class="text-danger">データベースエラー:'.$e->getMessage().'</p>';
		}
	}

	//エラーメッセージの取得
	public function GetEmailErrorMessage(){
		return $this->email_errorMessage;
	}

	public function GetPasswordErrorMessage(){
		return $this->password_errorMessage;
	}

	public function GetErrorMessage(){
		return $this->errorMessage;
	}
}

?>
<?php
//###########################################
// Model　アカウント登録
//###########################################
include ('../module/DBConnect.php');

class Register extends Model{

	public function Action(){
		// この中で登録処理を呼び出す
		if (isset($_POST["insert"])){

		   // アカウント登録処理を開始
		   $account = new Account();

		   // 入力チェックの結果を取得する
			$this->page_data['username_errorMessage'] = $account->Get_account_name_errorMessage();
			$this->page_data['email_errorMessage'] = $account->Get_email_errorMessage();
			$this->page_data['password_errorMessage'] = $account->Get_password_errorMessage();

		   // 入力チェックの結果エラーの判定
		   if( !$this->page_data['username_errorMessage'] && 
			   !$this->page_data['email_errorMessage'] && 
			   !$this->page_data['password_errorMessage']
			){
				// 入力されたアカウントをDBに保存する
				if ($account->Insert_Accounts()){
					// アカウント登録完了画面に遷移
					header("Location: /registered");
				}else{
					$errormessage = $account->Get_errorMessage();
					if($errormessage){
						echo "<script>alert('$errormessage');</script>";
					}
				}
			}
		}
		$this->page = new Page('アカウント登録', 'register', $this->page_data);
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
			$stmt->execute();
			echo "<script>alert('アカウントの登録に成功しました！');</script>";
			$rtnFlg = 1;
			
		}catch(PDOException $e){
			$this->errorMessage = '登録エラー';
			if($e->errorInfo[1] == 1062){
				$this->errorMessage = '既に登録されているアカウントです！';
			}else{
				error_log("[". date('Y-m-d H:i:s') . "]アカウント登録エラー：".addslashes($e->getMessage())."\n", 3, "/var/log/php/php_error.log");
			}
			$rtnFlg = 0;
		}
		return $rtnFlg;
	}

	// アカウント登録時の入力チェック
	private function Input_check() {
		// ユーザ名
		if(empty($this->account_name)){
			$this->account_name_errorMessage .= '<p>アカウント名を入力してください。</p>';
		}elseif(!preg_match("/^[a-zA-Z0-9]+$/", $this->account_name)){
			$this->account_name_errorMessage .= '<p>アカウント名は英数字のみで作成してください。</p>';
		}elseif(strlen($this->account_name)> 20){
			$this->account_name_errorMessage .= '<p>アカウント名は２０文字以下で作成してください。</p>';
		}
		// Ｅメール
		if(empty($this->email)){
			$this->email_errorMessage .= '<p>メールアドレスを入力してください。</p>';
		}elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->email_errorMessage .= '<p>メールアドレスの形式が正しくありません。</p>';
		}
		#パスワード
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

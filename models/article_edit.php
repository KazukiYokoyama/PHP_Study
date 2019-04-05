<?php
//###########################################
// Model　記事編集画面
//###########################################

/**
 * 記事編集画面出力に必要なパラメータの設定する
 * また、記事の登録・削除の要求があった場合に処理を実行する判断を行う
 */
class Article_Edit extends Model{
		protected $page_data = [
		'article_id'=>'',
		'title'=>'',
		'body'=>'',
		'title_errorMessage' => '',
		'errorMessage' => '',
		'css' => '<link rel="stylesheet" href="/css/article_edit.css">'
	];

	public function Action(){
		// article_idが存在する場合、記事を取得
		if(isset($_GET['article_id'])){
			$this->page_data['article_id'] = $_GET['article_id'];
			try{
				// データベース接続
				$pdo = DB_Connect::getPDO();
				$stmt = $pdo->prepare('SELECT * FROM Articles WHERE article_id = :article_id');
				$stmt->bindParam(':article_id',$_GET['article_id'], PDO::PARAM_INT);
				$stmt->execute();
				if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->page_data['title'] = $row['title'];
					$this->page_data['body'] = $row['body'];
				}
			}catch(PDOException $e){
				$this->error_message = 'データベースエラー:'.$e->getMessage();
			}
		}

		$form = new ArticleEditForm();
		//登録ボタン押下時の処理
		if(isset($_POST['submit'])){
			// 入力チェック
			if($form->InputCheck()){
				// 保存
				$form->Save();
			}
			// ページ用のプロパティに代入
			$this->page_data = [
				'article_id'=>$form->getArticle_id(),
				'title' => $form->getTitle(),
				'body' => $form->getBody(),
				'title_error_message' => $form->getTitleErrorMessage(),
				'error_message' => $form->getErrorMessage(),
				'css' => '<link rel="stylesheet" href="/css/article_edit.css">'
			];
		}

		//削除ボタン押下時の処理
		if(isset($_POST['delete'])){
			// 削除
			$form->Delete();
			// 画面遷移
			header("Location: /user.articles");
		}

		$this->page = new Page('記事編集画面', 'article_edit', $this->page_data);
	}
}

/**
 * 記事編集フォーム
 */
class ArticleEditForm{

	protected $article_id;				// 記事ID
	protected $title;					// タイトル
	protected $title_error_message;		// タイトルエラーメッセージ
	protected $body;					// 本文
	protected $error_message;			// 汎用エラーメッセージ
	protected $submit;					// 登録:ボタン
	protected $delete;					// 削除:ボタン

	//フォームから送信された値を取得
	function __construct(){
		if(isset($_POST['article_id'])){
			$this->article_id = $_POST['article_id'];
		}else{
			$this->article_id = '';
		}
		
		$this->title = $_POST['title'];
		if(!isset($this->title)){
			$this->title = '';
		}
		
		$this->body = $_POST['body'];
		if(!isset($this->body)){
			$this->body = '';
		}

		if(isset($_POST['submit'])){
			$this->submit = $_POST['submit'];
		}else{
			$this->submit = '';
		}

		if(isset($_POST['delete'])){
			$this->delete = $_POST['delete'];
		}else{
			$this->delete = '';
		}
	}

	/**
	 * 入力チェック
	 *
	 * @return integer
	 * 0: 失敗　1:成功
	 */
	public function InputCheck() :int{
		$sucsess = 1;
		// 入力の有無をチェック
		if(empty($this->title)){
			$this->title_error_message = 'タイトルを入力してください';
			$sucsess = 0;
		}elseif(mb_strlen($this->title) > 50){
			$this->title_error_message = 'タイトルは50文字以内で入力してください';
			$sucsess = 0;
		}
		return $sucsess;
	}

	/**
	 * 登録
	 *
	 * @return void
	 */
	public function Save(){
		try{
			// データベース接続
			$pdo = DB_Connect::getPDO();
			
			// article_idがなければ新規登録
			if(!$this->article_id){
				// インサート処理
				$stmt = $pdo->prepare('INSERT INTO Articles (account_id, title, body)VALUES(:account_id, :title, :body)');
				$stmt->bindParam(':account_id',$_SESSION['account_id'], PDO::PARAM_INT);
				$stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
				$stmt->bindParam(':body',$this->body, PDO::PARAM_STR);
				$stmt->execute();
				$this->article_id = $pdo->lastInsertId('article_id');
			}else{
				// アップデート処理
				$stmt = $pdo->prepare('UPDATE Articles SET title = :title, body = :body WHERE article_id = :article_id');
				$stmt->bindParam(':article_id',$this->article_id, PDO::PARAM_INT);
				$stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
				$stmt->bindParam(':body',$this->body, PDO::PARAM_STR);
				$stmt->execute();
			}
		}catch(PDOException $e){
			$this->error_message = 'データベースエラー:'.$e->getMessage();
		}
	}

	/**
	 * 削除
	 *
	 * @return void
	 */
	public function Delete(){
	// DBに接続し、削除を行う
		try{
			// データベース接続
			$pdo = DB_Connect::getPDO();
			// デリート処理
			$stmt = $pdo->prepare('DELETE FROM Articles WHERE article_id = :article_id');
			$stmt->execute([':article_id'=>$this->article_id]);
		}catch(PDOException $e){
			$this->errorMessage = 'データベースエラー:'.$e->getMessage();
		}
	}

	// 値の取得
	public function getArticle_id(){
		return $this->article_id;
	}

	public function getTitle(){
		return $this->title;
	}

	public function getTitleErrorMessage(){
		return $this->title_error_message;
	}

	public function getBody(){
		return $this->body;
	}

	public function getErrorMessage(){
		return $this->error_message;
	}

	public function getSubmit(){
		return $this->submit;
	}

	public function getDelete(){
		return $this->delete;
	}
}

?>
<?php

//###########################################
// Model　記事編集
//###########################################

class ArticleEdit extends Model{

	/**
	 * 記事編集画面の動作
	 * @return void
	 */
	public function Action(){
		$article_id = array_shift($this->url);
		$action_request = array_shift($this->url);

        // 保存
        if($action_request === 'save'){
			$ArticleEditForm = new ArticleEditForm();
			$ArticleEditForm->Save();
			$result = $ArticleEditForm->getResult();
            // APIレスポンス
            echo json_encode($result);
            exit;
		}
		$Article = new Article($article_id);
		$this->page_data['article_data'] = json_encode($Article->getVal());
		$this->page = new Page('投稿記事一覧', 'user/articleedit', $this->page_data);
	}
}

/**
 * 記事編集フォーム
 */
class ArticleEditForm{
	private $article_id;	// 記事ID
	private $title;			// タイトル
	private $body;			// 本文
	private $result = [
		'Success' => '',
		'Alert' => [
			'Warning' => []
		]
	];

	/**
	 * POSTデータの取得と各種入力チェックを実行
	 */
	function __construct(){
		$this->article_id = PF($_POST['article_id']);
		$this->title = PF($_POST['title']);
		$this->body = PF($_POST['body']);

		$this->validationTitle();
	}

    /**
     * タイトル　入力チェック
     * @return void
     */
    private function validationTitle(){
        if(empty($this->title)){
			$this->result['Alert']['Warning']['title'] = 'タイトルの入力がありません';
		}
    }

	/**
	 * 保存
	 * @return void
	 */
	public function Save(){
		// 入力チェック違反がある場合、保存しない
		if(count($this->result['Alert']['Warning'])){ return; }

		try{
			$pdo = DB_Connect::getPDO();
			$stmt = $pdo->prepare('INSERT INTO Articles (account_id, article_id, title, body) VALUES (:account_id, :article_id, :title, :body) ON DUPLICATE KEY UPDATE title = VALUES(title), body = VALUES(body)');
			$stmt->bindParam(':account_id', $_SESSION['account_id'], PDO::PARAM_INT);
			$stmt->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
			$stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
			$stmt->bindParam(':body', $this->body, PDO::PARAM_STR);
			$stmt->execute();
			$this->result['Success'] = 1;
		}catch(PDOException $e){
            // エラーログ出力
			error_log("記事編集失敗：".$e->getMessage().")", 0);
			$this->result['Success'] = 0;
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

/**
 * 記事情報
 */
class Article{
	private $Article = [];
	private $article_id;

	/**
	 * 引数のIDと一致する記事を検索する
	 *
	 * @param [type] $article_id
	 */
	function __construct($article_id){
		$this->article_id = $article_id;
		$this->Search();
	}

	/**
	 * 記事検索
	 * @return void
	 */
	private function Search(){
		$pdo = DB_Connect::getPDO();
		$stmt = $pdo->prepare('SELECT article_id, title, body FROM Articles WHERE account_id = :account_id AND article_id = :article_id');
		$stmt->bindParam(':account_id', $_SESSION['account_id'], PDO::PARAM_INT);
		$stmt->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
		$stmt->execute();

		$this->Article = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * 記事情報取得
	 * @return array
	 */
	public function getVal(){
		return $this->Article;
	}
}

?>
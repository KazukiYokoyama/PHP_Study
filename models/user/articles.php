<?php
//###########################################
// Model　記事一覧
//###########################################

class Articles extends Model{

	/**
	 * 記事一覧画面の動作
	 * @return void
	 */
	public function Action(){
		$action_request = array_shift($this->url);

        // 投稿記事リスト取得
        if($action_request === 'list'){
			$ArticlesList = new ArticlesList();
			$result = $ArticlesList->getList();
            // APIレスポンス返却
            echo json_encode($result);
            exit;
		}

		$this->page = new Page('投稿記事一覧', 'user/articles', $this->page_data);
	}
}

/**
 * 記事リスト
 */
class ArticlesList{
	private $list = [];

	function __construct(){
		$this->Search();
	}

	/**
	 * 記事検索
	 * @return void
	 */
	private function Search(){
		// ログインしているユーザーの記事を取得
		$pdo = DB_Connect::getPDO();
		$stmt = $pdo->prepare('SELECT * FROM Articles WHERE account_id = :account_id');
		$stmt->bindParam(':account_id', $_SESSION['account_id'], PDO::PARAM_INT);
		$stmt->execute();

		while($Article = $stmt->fetch(PDO::FETCH_ASSOC)){
			array_push($this->list, $Article);
		}
	}

	public function getList(){
		return $this->list;
	}
}
?>
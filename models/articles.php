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
        $contributor = array_shift($this->url);
        $action_request = array_shift($this->url);

        // 投稿記事リスト取得
        if($action_request === 'list'){
			$ArticlesList = new ArticlesList($contributor);
			$result = $ArticlesList->getList();
            // APIレスポンス返却
            echo json_encode($result);
            exit;
		}

        $this->page_data['contributor'] = $contributor;
		$this->page = new Page('投稿記事一覧', 'articles', $this->page_data);
	}
}

/**
 * 記事リスト
 */
class ArticlesList{
    private $contributor;
	private $list = [];

	function __construct($contributor){
        $this->contributor = $contributor;
		$this->Search();
	}

	/**
	 * 記事検索
	 * @return void
	 */
	private function Search(){
		// ログインしているユーザーの記事を取得
		$pdo = DB_Connect::getPDO();
		$stmt = $pdo->prepare('SELECT Articles.article_id, Articles.title, Accounts.account_name FROM Articles LEFT JOIN Accounts ON Articles.account_id = Accounts.account_id WHERE Accounts.account_name = :account_name');
		$stmt->bindParam(':account_name', $this->contributor, PDO::PARAM_STR);
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
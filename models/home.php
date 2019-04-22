<?php
//###########################################
// Model　トップページ
//###########################################

class Home extends Model{

    public function Action(){
        $action_request = array_shift($this->url);

        // 投稿者リストを取得
        if($action_request === 'contributor_list'){
			$ContributorList = new ContributorList();
			$result = $ContributorList->getList();
            // APIレスポンス返却
            echo json_encode($result);
            exit;
        }

        // 投稿記事リスト取得
        if($action_request === 'articles_list'){
			$ArticlesList = new ArticlesList();
			$result = $ArticlesList->getList();
            // APIレスポンス返却
            echo json_encode($result);
            exit;
		}

        $this->page = new Page('トップページ', 'home', $this->page_data);
    }
}

/**
 * 投稿者リスト
 */
class ContributorList{
	private $list = [];

	function __construct(){
		$this->Search();
	}

	/**
	 * 投稿者検索
	 * @return void
	 */
	private function Search(){
		// 最後に記事を投稿した順に投稿者を取得
		$pdo = DB_Connect::getPDO();
		$stmt = $pdo->prepare('SELECT Accounts.account_name FROM Accounts LEFT JOIN Articles ON Accounts.account_id=Articles.account_id GROUP BY account_name ORDER BY Articles.article_id DESC');
		$stmt->execute();

		while($Accounts = $stmt->fetch(PDO::FETCH_ASSOC)){
			array_push($this->list, $Accounts);
		}
	}

	public function getList(){
		return $this->list;
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
		$stmt = $pdo->prepare('SELECT Articles.article_id, Articles.title, Accounts.account_name FROM Articles LEFT JOIN Accounts ON Articles.account_id=Accounts.account_id ORDER BY Articles.article_id DESC LIMIT 5');
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
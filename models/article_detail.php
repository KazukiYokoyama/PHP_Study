<?php

//###########################################
// Model　記事編集
//###########################################

class Article_Detail extends Model{

	/**
	 * 記事編集画面の動作
	 * @return void
	 */
	public function Action(){
        $contributor = array_shift($this->url);
		$article_id = array_shift($this->url);
		$action_request = array_shift($this->url);

		$Article = new Article($contributor, $article_id);
		$this->page_data = $Article->getVal();
		$this->page = new Page('投稿記事一覧', 'article_detail', $this->page_data);
	}
}

/**
 * 記事情報
 */
class Article{
    private $contributor;
    private $article_id;
    private $Article = [];

	/**
	 * 引数のIDと一致する記事を検索する
	 *
	 * @param [type] $article_id
	 */
	function __construct($contributor, $article_id){
        $this->contributor = $contributor;
		$this->article_id = $article_id;
		$this->Search();
	}

	/**
	 * 記事検索
	 * @return void
	 */
	private function Search(){
		$pdo = DB_Connect::getPDO();
        $stmt = $pdo->prepare('SELECT Articles.title, Articles.body, Accounts.account_name FROM Articles LEFT JOIN Accounts ON Articles.account_id = Accounts.account_id WHERE Accounts.account_name = :account_name AND Articles.article_id = :article_id');
        $stmt->bindParam(':account_name', $this->contributor, PDO::PARAM_INT);
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
<?php
//###########################################
// Model　トップページ
//###########################################

class Articles extends Model{

	public function Action(){
		if($_SESSION['account_id']){
			//$this->page_data['msg'] = 'ログイン中だよ！';
		}

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


class ArticlesList{
	private $list = [];

	function __construct(){
		$this->Search();
	}

	private function Search(){

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
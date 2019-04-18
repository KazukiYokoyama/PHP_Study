<?php
//###########################################
// Model　ブログ記事一覧
//###########################################

// 入ってきたユーザの作った記事を一覧表示する
class Articlelist extends Model{
    public function Action(){
        
        // 記事一覧を取得する
        $Article = new Article();
        
        if(isset($_POST['del'])){
            $Article->Del_Article($_POST['del']);
        }
        
        $Article->Get_ArticleList();

        // 動的にtableを作成する
        $this->page_data['articlelist'] = $Article->Set_data();

        // return maketbth(row);
        $this->page = new Page('記事一覧', 'user/articlelist', $this->page_data);

    }

}

/**
 * 記事一覧クラス
 */
class Article{
    private $account_id;                    // アカウントＩＤ
    private $rows;                          // 記事一覧

	function __construct(){
		// 画面から送信された内容を取得
        $this->account_id = $_SESSION["account_id"];
        if(!isset($this->account_id)){
			$this->account_id = '';
		}
    }
    
    /**
     * 記事一覧の取得
     */
    public function Get_ArticleList(){
        // ユーザIDに一致する記事の一覧を返却する
        $pdo = DB_Connect::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM Articles WHERE account_id = :account_id');
        $stmt->execute([':account_id'=>$this->account_id]);
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            //$resultに格納した連想配列のplanを抽出し、$rowsに格納。planがある限り、$rowsに追加していく
            $this->rows[] = $result;
        }
        return;
    }

    /**
     * 記事の削除
     */
    public function Del_Article($del_id){
        // ユーザID、記事IDに一致する記事を削除する
        $pdo = DB_Connect::getPDO();
        $stmt = $pdo->prepare('DELETE FROM Articles WHERE account_id = :account_id AND article_id = :article_id');
        $stmt->bindValue(':account_id', $this->account_id);
        $stmt->bindValue(':article_id', $del_id);
        $stmt->execute();
        return;
    }

    /**
     * 記事一覧の作成
     */
    public function Set_data(){
        $td = "";
        $i = 1;
        foreach($this->rows as $row){
            $article_id = $row['article_id'];
            $title = $row['title'];
$td .= <<<EOT
    <tr>
        <td>$i</td>
        <td>$title</td>
        <td>
            <button type="button" class="update" onclick="location.href='./user/articles_edit/$article_id'">編集</button>
            <button type="submit" class="delete" name="del" value="$article_id">削除</button>
        </td>
    </tr>
EOT;
            $i++;
        }
        return $td;
    }
}

?>
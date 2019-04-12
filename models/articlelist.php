<?php
//###########################################
// Model　ブログ記事一覧
//###########################################
// include ('../module/DBConnect.php');

// 入ってきたユーザの作った記事を一覧表示する
class Articlelist extends Model{
    public function Action(){
        
        // 記事一覧を取得する
        $Article = new Article();
        $Article->Get_ArticleList();

        // 動的にtableを作成する
        $this->page_data['articlelist'] = $Article->Set_header();
        $this->page_data['articlelist'] .= $Article->Set_data();

        // return maketbth(row);
        $this->page = new Page('記事一覧', 'articlelist', $this->page_data);

    }

}

class Article{
    private $account_id;                    // アカウントＩＤ
    private $rows;                          // 記事一覧

	function __construct(){
		// 画面から送信された内容を取得
        $this->account_id = 6;//$_POST['account_id'];
        if(!isset($this->account_id)){
			$this->account_id = '';
		}
    }
    
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

    // ヘッダー
    public function Set_header(){
        return "<tr><th>No.</th><th>タイトル</th><th></th></tr>";
    }
            
    // データセット
    public function Set_data(){
        $td = "";
        $i = 1;
        foreach($this->rows as $row){
            $article_id = $row['article_id'];
            $title = $row['title'];
            // $td .= "<tr><td>".$i."</td><td>".$row['title']."</td>";
            // $td .= "<td><input type='button' value='編集' onclick='./user/articles_edit/'.$row['article_id']> ";
            // $td .= "<input type='button' value='削除' > <!--onclick=''>--></td></tr>";
$td .= <<<EOT
    <tr>
        <td>$i</td>
        <td>$title</td>
        <td>
            <button type="button" class="update" onclick="location.href='./user/articles_edit/$article_id'">編集</button>
            <button type="submit" class="delete">削除</button>
        </td>
    </tr>
EOT;
            $i++;
        }
        return $td;
    }
}

?>
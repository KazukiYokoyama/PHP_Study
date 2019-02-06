<?php

/**
 * このファイル内だけでしか使用しない場合、定数宣言を行う旨味がなくなってしまう。
 * DBへの接続情報を再利用したいのであれば、別ファイルに記述するように変更しましょう。
 */
define('HOST', 'localhost');
define('DATABASE', 'Blogs');
define('USER', 'phpstudy');
define('PASSWORD', 'phpstudy');

//###########################################
// PDOによるデータベースへの接続を行う
//###########################################
class DB_Connect{
    public $pdo;    //データベースの接続情報

    function __construct(){
        try{
            //データベースに接続
            $this->pdo = new PDO(
                'mysql:dbname='.DATABASE.';host='.HOST.';charset=utf8mb4',
                USER,
                PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }catch(PDOException $e){
            //接続失敗した場合エラー内容をログに残す
            $msg = "データベースへの接続に失敗しました<br>(" . $e->getMessage() . ")";
            //エラーログに書き込む
            /**
             * ちゃんとエラーログに出力してからpullリクだしてください。
             * 例）
             * error_log("データベースへの接続に失敗しました(".$e->getMessage().")", 0);
             * header("Location: /error");    // エラーページにリダイレクト
             */
        }
    }

    /**
     * データベースの接続情報を取得する
     */
    public function getPDO(){
        return $this->pdo;
    }

}



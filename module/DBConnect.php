<?php

define('HOST', 'localhost');
define('DATABASE', 'Blog');
define('USER', 'phpstudy');
define('PASSWORD', 'phpstudy');

//###########################################
// 　データベース接続
//###########################################

class DB_Connect{
    //データベースの接続情報
    public $pdo;
    
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
        }
    }

    /**
     * データベースの接続情報を取得する
     */
    public function getPDO(){
        return $this->pdo;
    }

}



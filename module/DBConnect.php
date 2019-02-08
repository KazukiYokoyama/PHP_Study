<?php

//###########################################
// PDOによるデータベースへの接続を行う
//###########################################
class DB_Connect{
    public $pdo;    //データベースの接続情報

    function __construct(){
        try{
            //データベースに接続
            $this->pdo = new PDO(
                'mysql:dbname=Blogs;host=localhost;charset=utf8mb4',
                'phpstudy',
                'phpstudy',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }catch(PDOException $e){
            //接続失敗した場合エラー内容をログに残す
            $msg = "データベースへの接続に失敗しました<br>(" . $e->getMessage() . ")";
            //エラーログに書き込む
            error_log("データベースへの接続に失敗しました(".$e->getMessage().")", 0);
            header("Location: /error");    // エラーページにリダイレクト
        }
    }

    /**
     * データベースの接続情報を取得する
     */
    public function getPDO(){
        return $this->pdo;
    }

}



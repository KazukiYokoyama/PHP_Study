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
                'mysql:dbname=Blog;host=localhost;charset=utf8mb4',
                'phpstudy',
                'phpstudy',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }catch(PDOException $e){
            //エラーログに書き込む
            error_log("データベースへの接続に失敗しました(".$e->getMessage().")", 0);
            header("Location: /failure");    // エラーページにリダイレクト
        }
    }

    /**
     * データベースの接続情報を取得する
     */
    public function getPDO(){
        return $this->pdo;
    }

}



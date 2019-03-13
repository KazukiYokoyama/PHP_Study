-- --------------------------------------------------------
-- ホスト:                          127.0.0.1
-- サーバーのバージョン:                   10.3.12-MariaDB - MariaDB Server
-- サーバー OS:                      Linux
-- HeidiSQL バージョン:               9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Blog のデータベース構造をダンプしています
DROP DATABASE IF EXISTS `Blog`;
CREATE DATABASE IF NOT EXISTS `Blog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Blog`;

-- ユーザー作成 phpstudy
CREATE USER IF NOT EXISTS 'phpstudy'@'localhost' IDENTIFIED BY 'phpstudy';
-- phpstudyにBlogデータベースの操作権限を付与する
GRANT ALL PRIVILEGES ON Blog.* TO 'phpstudy'@'localhost';
-- 設定を反映
FLUSH PRIVILEGES;

--  テーブル Blog.Accounts の構造をダンプしています
DROP TABLE IF EXISTS `Accounts`;
CREATE TABLE `Accounts` (
	`account_id` BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'アカウントID',
	`account_name` VARCHAR(20) NULL DEFAULT NULL UNIQUE COMMENT 'アカウント名',
	`email` VARCHAR(100) NULL DEFAULT NULL UNIQUE  COMMENT 'メールアドレス',
	`password_hash` VARCHAR(255) NULL DEFAULT NULL COMMENT 'パスワードハッシュ'
)
COMMENT='サービス利用者のアカウントを保持する'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6
;

-- エクスポートするデータが選択されていません
--  テーブル Blog.Articles の構造をダンプしています
DROP TABLE IF EXISTS `Articles`;
CREATE TABLE IF NOT EXISTS `Articles` (
	`article_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '記事ID',
	`account_id` bigint(20) unsigned DEFAULT NULL COMMENT 'アカウントID（=Accounts:account_id）',
	`title` varchar(50) DEFAULT NULL COMMENT 'タイトル',
	`body` text DEFAULT NULL COMMENT '本文',
	PRIMARY KEY (`article_id`),
	KEY `account_id` (`account_id`),
	CONSTRAINT `Articles_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `Accounts` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment='ブログの記事を保持する';

-- エクスポートするデータが選択されていません
--  テーブル Blog.Logs の構造をダンプしています
DROP TABLE IF EXISTS `Logs`;
CREATE TABLE IF NOT EXISTS `Logs` (
	`log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ログID',
	`date_reported` date DEFAULT NULL COMMENT '発行日付',
	`description` text DEFAULT NULL COMMENT '内容',
	PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment='操作ログを保持する';

-- エクスポートするデータが選択されていません
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

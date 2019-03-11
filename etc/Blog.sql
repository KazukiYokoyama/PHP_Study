DROP TABLE IF EXISTS `Accounts`;
CREATE TABLE IF NOT EXISTS `Accounts` (
  `account_id` bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'アカウントID',
  `account_name` varchar(20) DEFAULT NULL UNIQUE COMMENT 'アカウント名',
  `email` varchar(100) DEFAULT NULL UNIQUE COMMENT 'メールアドレス',
  `password_hash` varchar(255) DEFAULT NULL COMMENT 'パスワードハッシュ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='サービス利用者のアカウントを保持する';
DROP TABLE IF EXISTS `Accounts`;
CREATE TABLE IF NOT EXISTS `Accounts` (
  `account_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '�A�J�E���gID',
  `account_name` varchar(20) DEFAULT NULL UNIQUE COMMENT '�A�J�E���g��',
  `email` varchar(100) DEFAULT NULL UNIQUE COMMENT '���[���A�h���X',
  `password_hash` varchar(255) DEFAULT NULL COMMENT '�p�X���[�h�n�b�V��',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment='�T�[�r�X���p�҂̃A�J�E���g��ێ�����';
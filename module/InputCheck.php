<?php

/**
 * 入力チェックの判定を提供する trait
 */
trait InputCheck{
	/**
	 * 必須入力チェック
	 *
	 * @param string $val
	 * @return integer
	 */
	public function RequiredCheck($val='') :bool{
		if(empty($val)){
			return false;
		}
		return true;
	}

	/**
	 * メールアドレス妥当性チェック
	 *
	 * @param string $val
	 * @return integer
	 */
	public function EmailCheck($val='') :bool{
		if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
			return false;
		}
		return true;
	}

	/**
	 * パスワード妥当性チェック
	 * 使用可能文字はアルファベットの大文字・小文字と半角数字
	 *
	 * @param string $val
	 * @return integer
	 */
	public function PasswordCheck($val='') :bool{
		if(!preg_match("/^[a-zA-Z0-9]+$/", $val)){
			return false;
		}
		return true;
	}

	/**
	 * アカウント妥当性チェック
	 * 使用可能文字はアルファベットの大文字・小文字と半角数字
	 *
	 * @param string $val
	 * @return integer
	 */
	public function AccountNameCheck($val='') :bool{
		if(!preg_match("/^[a-zA-Z0-9]+$/", $val)){
			return false;
		}
		return true;
	}
}


?>
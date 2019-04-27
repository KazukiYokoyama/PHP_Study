<?php
use PHPUnit\Framework\TestCase;

include ('module/InputCheck.php');

/**
 * 入力チェックの判定のテスト
 */
class InputCheckTest extends TestCase{
	private $target;

	public function setUp() :void{
		$this->target = $this->getMockForTrait(InputCheck::class);
	}
	
	/**
	 * 必須入力チェックのテスト
	 *
	 * @return void
	 */
	public function testRequiredCheck(){
		// 適切な文字列が入力された場合：true
		$this->assertTrue($this->target->RequiredCheck('test'));

		// 半角スペースのみの入力：ture　（これが良いかは意見が分かれるところ）
		$this->assertTrue($this->target->RequiredCheck(' '));

		// 全角スペースのみの入力：ture　（これが良いかは意見が分かれるところ）
		$this->assertTrue($this->target->RequiredCheck('　'));

		// 入力無し（blnk）：false
		$this->assertFalse($this->target->RequiredCheck(''));

		// 入力無し（null）：false
		$this->assertFalse($this->target->RequiredCheck(null));
	}

	/**
	 * メールアドレス妥当性チェックのテスト
	 *
	 * @return void
	 */
	public function testEmailCheck(){
		// 適切なメールアドレスが入力された場合：true
		$this->assertTrue($this->target->EmailCheck('test@test.jp'));
		$this->assertTrue($this->target->EmailCheck('TesT@test.jp'));			// 大文字混じり
		$this->assertTrue($this->target->EmailCheck('t-e.s_t@test.jp'));		// 記号有り（-.*）

		// メールアドレスの体裁を成していない：false
		$this->assertFalse($this->target->EmailCheck('test'));					// @、domain無し
		$this->assertFalse($this->target->EmailCheck('test@'));					// domain無し
		$this->assertFalse($this->target->EmailCheck('test＠test.jp'));			// @が大文字
		$this->assertFalse($this->target->EmailCheck('test@test@test.jp'));		// @が複数
		$this->assertFalse($this->target->EmailCheck('te..st@test.jp'));		// .の連続使用
		$this->assertFalse($this->target->EmailCheck('test.@test.jp'));			// @直前の.
		$this->assertFalse($this->target->EmailCheck('te＿st.@test.jp'));		// 大文字の記号

	}

	/**
	 * パスワード妥当性チェックのテスト
	 *
	 * @return void
	 */
	public function testPasswordCheck(){
		// 適当な文字列が入力された場合：true
		$this->assertTrue($this->target->PasswordCheck('test1234'));
		$this->assertTrue($this->target->PasswordCheck('TesT1234'));			// 大文字混じり

		// アルファベットの大文字・小文字と半角数字以外が入力された場合:false
		$this->assertFalse($this->target->PasswordCheck('te@st'));				// 記号入り
		$this->assertFalse($this->target->PasswordCheck('test１２３４'));		// 数字が全角
		$this->assertFalse($this->target->PasswordCheck(' '));					// 半角スペースのみの入力
	}

	/**
	 * アカウント妥当性チェックのテスト
	 *
	 * @return void
	 */
	public function testAccountNameCheck(){
		// 適切な文字列が入力された場合：true
		$this->assertTrue($this->target->AccountNameCheck('test1234'));
		$this->assertTrue($this->target->AccountNameCheck('TesT1234'));			// 大文字混じり

		// アルファベットの大文字・小文字と半角数字以外が入力された場合:false
		$this->assertFalse($this->target->AccountNameCheck('te@st'));			// 記号入り
		$this->assertFalse($this->target->AccountNameCheck('test１２３４'));	// 数字が全角
		$this->assertFalse($this->target->AccountNameCheck(' '));				// 半角スペースのみの入力
	}
}

?>

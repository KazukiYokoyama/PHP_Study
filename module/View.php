<?php

class Page{
	private $title;
	private $template;
	private $data;
	private $layout;

	function __construct(string $title='', string $template='', array $data=[], string $layout=null) {
		$this->title = $title;
		$this->template = $template;
		$this->data = $data;
		$this->layout = $layout ?? 'public_default';
	}

	private function copy(string $key, $value): self{
		$new = clone $this;
		$new->{$key} = $value;
		return $new;
	}

	public function setTitle(string $title) :self{
		return $this->copy('title', $title);
	}

	public function setTemplate(string $template) :self{
		return $this->copy('template', $template);
	}

	public function setData(array $data) :self{
		return $this->copy('data', $data);
	}

	public function setLayout(string $layout) :self{
		return $this->layout('data', $layout);
	}

	public function getTitle() :string{
		return $this->title;
	}

	public function getTemplate() :string{
		return $this->template;
	}

	public function getData() :array{
		return $this->data;
	}

	public function getLayout() :string{
		return $this->layout;
	}
}

//###########################################
// リクエストされたページに応じて、
// タイトルやレイアウト等を適切な組み合わせにして表示する
//###########################################
Class View{
	private $page;      // Viewのpath
	private $data;      // Modelの実行結果

	function __construct(Page $page){
		$this->page = $page;
	}

	/**
	 * ページの内容を表示する
	 */
	public function Print(){
		if(file_exists('../views/'.$this->page->getTemplate().'.view.php')){
			// ページが有る場合、指定のレイアウトを読み込む
			// 分かりづらいが、レイアウトの方でBody()を呼び出している
			require('../views/layouts/'.$this->page->getLayout().'.layout.php');
		}else{
			// ページが無い場合、404（Not Found）を表示する
			header("HTTP/1.0 404 Not Found");
			header("Location: /404");
		}
	}

	// bodyの読み込み
	private function Body(){
		require('../views/'.$this->page->getTemplate().'.view.php');
	}

	/**
	 * Modelから渡されたデータを取得する
	 *
	 * @param string $property
	 * @param integer $no_escape （デフォルト:特殊文字をエスケープする 1:エスケープしない）
	 * @return string
	 */
	private function getData(string $property, int $no_escape=0) :string{
		$data = $this->page->getData();
		if(isset($data[$property])){
			$data = (string) $data[$property];
			if($no_escape){ return $data; }
			return htmlspecialchars($data, ENT_QUOTES);
		}
		return '';
	}
}

?>
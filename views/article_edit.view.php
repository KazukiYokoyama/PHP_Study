<div class="container">
	<div class="row">
		<div class="col-lg-7 col-sm-12 mx-auto mt-5">
			<div class="text-center">
				<h2>記事編集画面</h2>
			</div>
			<form name="ArticleEditForm" action="" method="post">
				<input type="hidden" name="article_id" value="<?= $this->getData('article_id') ?>">
				<?= $this->getData('errorMessage'); ?>
				<div class="form-group pt-3">
					<label for="exampleInputTitle">タイトル<span class="text-danger text-outline small">必須</span></label>
					<input type="title" name="title" class="form-control" id="exampleInputTitle" value="<?= $this->getData('title') ?>">
					<input type="hidden" name="title" value="<?= $this->getData('title') ?>">
					<?= $this->getData('title_errorMessage'); ?>
				</div>
				<div class="form-group pt-3 pb-3">
					<label for="textarea1">本文</label>
					<textarea id="textarea1" name="body" class="form-control" rows="10"><?= $this->getData('body') ?></textarea>
					<input type="hidden" name="body" value="<?= $this->getData('body') ?>">
				</div>
				<div class="form-group text-center">
					<button type="submit" name="submit" class="btn btn-primary">登録</button>
					<button type="submit" name="cancel" class="btn btn-Light ml-2 mr-2">キャンセル</button>
				<?php
					if (isset($_GET["article_id"])) {
						echo '<button type="submit" name="delete" class="btn btn-danger">削除</button>';
					}
				?>
				</div>
			</form>
		</div>
	</div>
</div>
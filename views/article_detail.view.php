<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1><?= $this->getData('title') ?></h1>
		</div>
        <div id="Articles" class="panel panel-primary">
			<?= $this->getData('body') ?>
		</div>
		<a href="/articles/<?= $this->getData('account_name') ?>"><?= $this->getData('account_name') ?>が投稿した記事</a>
	</div>
</div>

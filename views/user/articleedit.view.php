<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>投稿記事</h1>
		</div>
		<div id="ArticleEditForm">
			<div class="form-group">
				<label>タイトル</label>
				<input type="text" v-model="Article.title" class="form-control" placeholder="Article Title">
				<p class="alert-warning" v-text="Alert.Warning.title"></p>
	  		</div>
	  		<div class="form-group">
				<label>本文</label>
				<textarea v-model="Article.body" class="form-control" placeholder="Article Body"></textarea>
				<p class="alert-warning" v-text="Alert.Warning.body"></p>
	  		</div>
	  		<button class="btn btn-primary" @click="submit">保存</button>
			<input type="hidden" v-model="Article.article_id">
		</div>
	</div>
</div>

<script type="application/json" id="article-data">
<?= $this->getData('article_data') ?>
</script>
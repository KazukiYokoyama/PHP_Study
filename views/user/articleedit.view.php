<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>記事投稿</h1>
		</div>
		<div id="ArticleEditForm">
			<div class="form-group">
				<label>タイトル</label>
				<input type="text" v-model="Article.title" class="form-control" placeholder="Article Title">
				<template v-if="isErrorTitle">
					<p class="alert-warning" v-text="Alert.Warning.title"></p>
				</template>
	  		</div>
	  		<div class="form-group">
				<label>本文</label>
				<textarea v-model="Article.body" class="form-control" placeholder="Article Body"></textarea>
				<template v-if="isErrorBody">
					<p class="alert-warning" v-text="Alert.Warning.body"></p>
				</template>
	  		</div>
	  		<button class="btn btn-primary" @click="submit">保存</button>
			<button class="btn" @click="back">記事一覧</button>
			<input type="hidden" v-model="Article.article_id">
		</div>
	</div>
</div>

<script type="application/json" id="article-data">
<?= $this->getData('article_data') ?>
</script>
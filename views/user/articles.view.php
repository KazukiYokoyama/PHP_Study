<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>投稿記事一覧</h1>
		</div>
		<table id="articles_list">
			<tr>
				<th>記事ID</th>
				<th>タイトル</th>
			</tr>
			<tr v-for="(item, i) in list" :key="item">
				<td>{{ item.article_id }}</td>
				<td>{{ item.title }}</td>
			</tr>
		</table>
	</div>
</div>
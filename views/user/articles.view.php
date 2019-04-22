<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>投稿記事一覧</h1>
		</div>
		<table id="Articles">
			<tr>
				<th>記事ID</th>
				<th>タイトル</th>
			</tr>
			<template v-if="ListCount">
				<tr v-for="item in list" :key="item.article_id">
					<td>{{ item.article_id }}</td>
					<td>
						<a v-bind:href="'/user/articleedit/'+item.article_id">{{ item.title }}</a>
					</td>
				</tr>
			</template>
			<template v-else>
				<tr>
					<td colspan="2">投稿された記事はありません。</td>
				</tr>
			</template>
		</table>
	</div>
</div>
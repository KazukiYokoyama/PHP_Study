<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>Blog Home</h1>
		</div>
		<div>
			<h2>投稿者</h2>
			<ul id="Contributors">
				<template v-if="ListCount">
					<li v-for="item in list" :key="item.account_name">
						<a v-bind:href="'/articles/'+item.account_name">{{ item.account_name }}</a>
					</li>
				</template>
			</ul>
		</div>
		<div>
			<table id="Articles">
				<tr>
					<th>投稿者</th>
					<th>タイトル</th>
				</tr>
				<template v-if="ListCount">
					<tr v-for="item in list" :key="item.article_id">
						<td>{{ item.account_name }}</td>
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
</div>
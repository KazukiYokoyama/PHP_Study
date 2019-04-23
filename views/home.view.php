<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>Blog Home</h1>
		</div>
		<div class="row">
			<div class="col-md-9 table-responsive">
				<table id="Articles" class="table table-bordered">
					<tr>
						<th>記事</th>
						<th width="200px">投稿者</th>
					</tr>
					<template v-if="ListCount">
						<tr v-for="item in list" :key="item.article_id">
							<td>
								<a v-bind:href="'/user/articleedit/'+item.article_id">{{ item.title }}</a>
							</td>
							<td>{{ item.account_name }}</td>
						</tr>
					</template>
					<template v-else>
						<tr>
							<td colspan="2">投稿された記事はありません。</td>
						</tr>
					</template>
				</table>
			</div>
			<div class="col-md-3">
				<h2>投稿者</h2>
				<ul id="Contributors" class="list-group list-group-flush">
					<template v-if="ListCount">
						<li class="list-group-item" v-for="item in list" :key="item.account_name">
							<a v-bind:href="'/articles/'+item.account_name">{{ item.account_name }}</a>
						</li>
					</template>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>投稿記事一覧</h1>
		</div>
        <div id="Articles">
            <table>
                <tr>
                    <th>記事ID</th>
                    <th>タイトル</th>
                </tr>
                <template v-if="ListCount">
                    <tr v-for="item in list" :key="item.article_id">
                        <td>{{ item.article_id }}</td>
                        <td>
                            <a v-bind:href="'/article_detail/'+item.account_name+'/'+item.article_id">{{ item.title }}</a>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="2">投稿された記事はありません。</td>
                    </tr>
                </template>
            </table>
            <input type="hidden" id="contributor" value="<?= $this->getData('contributor') ?>">
        </div>
	</div>
</div>

/**
 * 記事リスト
 */
var ArticlesList = new Vue({
	el: '#articles_list',
	data: {
		list: []
	},
	methods: {
		window:onload = function() {
			// 記事リストを取得する
			let params = new URLSearchParams();
			axios.post('/user/articles/list', params, axios_post_config)
			.then(function(res){
				// 記事リストを表示
				ArticlesList.list = res.data;
			})
			.catch(function (error){
				this.AjaxError(error);
			});
		}
	}
});

/**
 * 記事リスト
 */
var Articles = new Vue({
	el: '#Articles',
	data: {
		list: [
			article_id=> '',
			title=> ''
		]
	},
	mixins:[AxiosAjax],
	computed: {
		ListCount(){
			return this.list.length > 0;
		}
	},
	methods: {
		window:onload = function() {
			// 記事リストを取得する
			let params = new URLSearchParams();
			axios.post('/user/articles/list', params, axios_post_config)
			.then(function(res){
				// 記事リストを表示
				Articles.list = res.data;
			})
			.catch(function (error){
				this.AjaxError(error);
			});
		}
	}
});

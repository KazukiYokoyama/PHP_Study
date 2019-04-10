/**
 * 記事リスト
 */
var ArticleUpdate = new Vue({
	el: '#ArticleEditForm',
	data: {
		Article:{},
		// アラートメッセージ
		Alert:{
			Warning:[]
		}
	},
	mixins:[AxiosAjax],
	created: function(){
		let article_data = document.getElementById("article-data");
		let article_json_data = JSON.parse(article_data.textContent);
		if(article_json_data){
			this.Article = article_json_data;
		}
	},
	methods:{
		// 保存ボタン押下処理
		submit(){
			// 送信パラメータ設定
			let params = new URLSearchParams();
			params.append("article_id", this.Article.article_id);
			params.append("title", this.Article.title);
			params.append("body", this.Article.body);

			// Ajax Post
			// 記事保存APIに送信
			axios.post('/user/articleedit/'+this.Article.article_id+'/save', params, axios_post_config)
			.then(function(res){
				if(res.data.Success){
					alert('保存しました');
				}else{
					// アラートメッセージを表示
					ArticleUpdate.Alert = res.data.Alert;
				}
			})
			.catch(function (error){
				ArticleUpdate.AjaxError(error);
			});
		}
	}
});

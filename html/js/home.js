/**
 * 投稿者リスト
 */
var Contributors = new Vue({
	el: '#Contributors',
	data: {
		list: []
	},
	mixins:[AxiosAjax],
	computed: {
		ListCount(){
			return this.list.length > 0;
		}
    },
    created: function () {
        // 投稿者リストを取得する
        let params = new URLSearchParams();
        axios.post('/home/contributor_list', params, axios_post_config)
        .then(function(res){
            // 投稿者リストを表示
            Contributors.list = res.data;
        })
        .catch(function (error){
            this.AjaxError(error);
        });
    }
});

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
	created: function () {
        // 記事リストを取得する
        let params = new URLSearchParams();
        axios.post('/home/articles_list', params, axios_post_config)
        .then(function(res){
            // 記事リストを表示
            Articles.list = res.data;
        })
        .catch(function (error){
            this.AjaxError(error);
        });
	}
});
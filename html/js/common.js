// 送信設定
const axios_post_config = {
    headers:{
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    withCredentials:true,
}

/**
 * Axios Ajax関連
 */
const AxiosAjax = {

    methods:{
        AjaxError(error){
            // エラー処理
            if (error.response) {
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.statusText);
                console.log(error.response.headers);
            } else if (error.request) {
                console.log(error.request);
            } else {
                console.log('Error', error.message);
            }
            console.log(error.config);
        }
    }
}
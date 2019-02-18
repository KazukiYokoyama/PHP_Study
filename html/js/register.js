/**
 * アカウント登録
 */
var SygnUp = new Vue({
    el:"#SygnUpForm",
    data:{
        // 登録用パラメータ
        SygnUp:{
            account_name:'',    // アカウント名
            email:'',           // メールアドレス
            password:''         // パスワード
        },
        // アラートメッセージ
        Alert:{
            Warning:[]
        }
    },
    mixins:[AxiosAjax],
    methods:{
        // アカウント登録ボタン押下処理
        // フォームから認証パラメータを取得し、アカウント登録APIに送信する
        submit(){
            // 送信パラメータ設定
            let params = new URLSearchParams();
            params.append("account_name", this.SygnUp.account_name);
            params.append("email", this.SygnUp.email);
            params.append("password", this.SygnUp.password);

            // Ajax Post
            // アカウント登録APIに送信
            axios.post('/register/sygnup', params, axios_post_config)
            .then(function(res){
                if(res.data.Success){
                    // 
                    location.href = './registered';
                }
                if(res.data.Success === 0){
                    location.href = './failure';
                }
                // アラートメッセージを表示
                SygnUp.Alert = res.data.Alert;
            })
            .catch(function (error){
                this.AjaxError(error);
            });
        }
    }
});

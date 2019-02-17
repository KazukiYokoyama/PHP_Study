/**
 * ログイン認証
 */
var LoginAthentication = new Vue({
    el:"#LoginForm",
    data:{
        // 認証用パラメータ
        Athentication:{
            email:'',             // メールアドレス
            password:''           // パスワード
        },
        // アラートメッセージ
        Alert:{
            Warning:[]
        }
    },
    mixins:[AxiosAjax],
    methods:{
        // ログインボタン押下処理
        // フォームから認証パラメータを取得し、ログイン認証APIに送信する
        submit(){
            // 送信パラメータ設定
            let params = new URLSearchParams();
            params.append("email", this.Athentication.email);
            params.append("password", this.Athentication.password);

            // Ajax Post
            // ログイン認証APIに送信
            axios.post('/login/authentication', params, axios_post_config)
            .then(function(res){
                // アラートメッセージの取得
                LoginAthentication.Alert = res.data.Alert;
                console.log(Object.keys(LoginAthentication.Alert.Warning).length);
            })
            .catch(function (error){
                this.AjaxError(error);
            });
        }
    }
});

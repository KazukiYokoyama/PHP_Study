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
        // エラー内容
        Error:[]
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

            // ログイン認証APIに送信
            this.Post('/login/authentication', params);
        },
        // ログイン認証完了後処理
        Action(res){
            this.Error = res.data.Error;

        }
    }
});
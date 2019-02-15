//Vueのインスタンスの定義
var app = new Vue({
    el:"#LoginForm",　//vueのインスタンスが紐づくDOM要素ののセレクタ
    data:{　　　//ここで定義した値がv-model="hoge"や{{hoge}}の初期値に反映される
        Athentication:{
            email:'',             //v-model="param"の初期値
            password:''           //v-model="result"の初期値
        },
        Error:[]
    },

    methods:{　  //v-on:click="hoge"などのイベントに紐づく関数定義
        login: function(){ //v-on:click="post"時の処理
        //Axiosを使ったAJAX
　　　　　 //リクエスト時のオプションの定義
        config = {
            headers:{
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type':'application/x-www-form-urlencoded'
            },
            withCredentials:true,
        }
　　　　　 //vueでバインドされた値はmethodの中ではthisで取得できる
        //param = JSON.parse(this.LoginForm);
        //console.log(this.Athentication.email);
        params = new URLSearchParams();
        params.append("email", this.Athentication.email);
        params.append("password", this.Athentication.password);
        //Ajaxリクエスト
        /*
            Axiosはプロミスベースのモジュールなので
　　　　　　　.thenや.catchを使う。
　　　　　　　.then((res => {}))の内側ではスコープが違うので
　　　　　　　Vueでバインドされた値をthisでは取れない
        */
        axios.post('/login/authentication',params,config)
        .then(function(res){
　　　　　　　//vueにバインドされている値を書き換えると表示に反映される
            app.Error = res.data.error;
            //console.log('aaa:'+LoginForm.Error.email);
            console.log(res.data);
        })
        .catch(function(res){
            //vueにバインドされている値を書き換えると表示に反映される
　　　　　　　//app.result = res.data;
            console.log(res.data);
        })
        }
    }
});
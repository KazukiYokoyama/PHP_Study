<?php
//###########################################
// Model　アカウント登録
//###########################################

<<<<<<< HEAD:models/register.php
function handle($params){
    return [
        'page' => 'register',
=======
class Signup extends Model{
    protected $page_data = [
        'page' => 'signup',
>>>>>>> 8e054da73fcf9a220957c687e2ae7b01f049d083:models/signup.php
        'layout' => 'public_default',
        'title' => 'アカウント登録'
    ];
}

?>
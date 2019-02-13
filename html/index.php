<?php

include_once ('../module/Controller.php');
include_once ('../module/Model.php');

// URL取得
$url = explode('/', filter_input(INPUT_GET, 'url'));

$Controller = new Controller($url);
$Controller->main();

exit;

?>

<?php

include ('../module/Controller.php');

// URL取得
$url = explode('/', filter_input(INPUT_GET, 'url'));

$Controller = new Controller($url);
$Controller->main();

exit;

?>

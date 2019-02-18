<?php

/**
 * POST Filter
 */
function PF(&$data){
    if(isset($data)){
        return $data;
    }
    return '';
}

?>
<?php

/**
 * POST Filter
 *
 * @param [type] $data
 * @return void
 */
function PF(&$data){
    if(isset($data)){
        return $data;
    }
    return '';
}


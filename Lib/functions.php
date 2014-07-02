<?php

/**
 * Returns true if the function detects we are on a local development env.
 * Detection is done by comparing the host against and ip begining with 127
 * @param string $host The projects host name
 * @param string $ip A local ip segment (127 is the default)
 * @return type
 */
function isDev($host = null, $ip = '127'){
    
    if(empty($host)){
        $host = $_SERVER['SERVER_NAME'];
    }
    
    return (strpos(gethostbyname($host), $ip)===false)?false:true;
}

/**
 * Based upon the data type of the accessed page, we want the content indicies in the header to match
 * @param array $content
 * @return string
 */
function model($content){
	$model = null;
	$model = (isset($content['Content'])?'Content':$model);
	$model = (isset($content['Post'])?'Post':$model);
	$model = (isset($content['Page'])?'Page':$model);
	return $model;
}
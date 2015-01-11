<?php

include '/Users/xingyue/outcode/git/simple_php_lib/simplehtmldom_1_5/simple_html_dom.php';

foreach( get_urls() as $url){
	$html = file_get_html($url);
	do_html_document($html);
}

function get_urls(){
	$urls = array();

	return $urls;
}

function do_html_document($html){

}

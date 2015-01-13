#!/usr/bin/php
<?php
define('ROOT',dirname(__FILE__));
include ROOT . '/smarty/Smarty.class.php';

$smarty = new Smarty();
$smarty->template_dir = ROOT . "/templates/";
$smarty->compile_dir = ROOT . "/templates_c/";

$filename = $argv[2];
$dir = $argv[1];

$file_ext = parseLanguage($filename);

$smarty->assign("dir",$argv[1]);
$smarty->assign("filename",$argv[2]);

$tpl = $file_ext . '/tool.tpl';

switch($file_ext){
	case "go":
		$tpl = $file_ext . '/channel_pool.tpl';
		break;
	case "php":
		if(strpos($filename,"grab")){
			$tpl = $file_ext . '/grab.tpl';
		}
		break;
	case "sh":
		$dot_pos = strrpos($filename,'.');
		$_pos = strrpos($filename,'_');
		$service_name = substr($filename,$_pos + 1,$dot_pos - $_pos - 1);
		$smarty->assign("service_name",$service_name);
		$tpl = $file_ext . "/kill.tpl";
		break;	
}

$smarty->display($tpl);

function parseLanguage($filename){
	$file_ext = substr($filename,strrpos($filename,'.') + 1);
	return $file_ext;
}

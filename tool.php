#!/usr/bin/php
<?php

define('ROOT',dirname(__FILE__));
include ROOT . '/smarty/Smarty.class.php';

$smarty = new Smarty();
$smarty->template_dir = ROOT . "/templates/";
$smarty->compile_dir = ROOT . "/templates_c/";
$smarty->assign("dir",$argv[1]);
$smarty->assign("filename",$argv[2]);
$smarty->display("tool.tpl");

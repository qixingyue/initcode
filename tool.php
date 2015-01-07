#!/usr/bin/php
<?php

define('ROOT',dirname(__FILE__));
include ROOT . '/smarty/Smarty.class.php';

$smarty = new Smarty();
$smarty->template_dir = ROOT . "/templates/";
$smarty->assign("dir",$argv[1]);
$smarty->assign("filename",$argv[2]);
$smarty->display("tool.tpl");

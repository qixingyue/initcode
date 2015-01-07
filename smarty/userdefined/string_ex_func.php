<?php
// 字符串处理的相关函数,可以在模板中直接使用

function str_file_cut($text,$len){
	return Util::substr_cut_files($text,$len);
}

function str_cut($text,$len){
    return Util::substr_cut($text,$len);
}

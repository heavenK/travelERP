<?php

function FileGetContents($url){
	$d = file_get_contents($url);
	$d = str_replace('﻿','',$d);//未知原因数据序列化后多3个不可见字符问题，序列化失败解决办法。
	$d = unserialize($d);
	return $d;
}


function FileGetContents_b($url){
	$d = file_get_contents($url);
	$d = str_replace('




','',$d);//未知原因2。
	$d = unserialize($d);
	return $d;
}




?>
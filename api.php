<?php
	header('Access-Control-Allow-Origin:*');
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	include_once("Parsedown.php");

	$Parsedown = new Parsedown();
	//获取URL地址
	$url = $_GET['url'];
	//获取文件后缀
	$suffix = explode(".",$url);
	$suffix = end($suffix);
	//判断文件后缀
	if($suffix != 'md') {
		echo '尚未识别的文件！';
		exit;
	}
	//对URL进行md5加密用于文件存储
	$filename = md5($url);
	$filename = "caches/".$filename.".md";
	//获取文件修改时间
	@$ftime = filemtime($filename);
	(int)@$ftime = date('YmdH',$ftime);
	(int)$thetime = date('YmdH',time());

	//计算时差
	$diff = $thetime - $ftime;
	
	//获取样式
	$style = $_GET['style'];
	//获取方法
	$method = $_GET['method'];
	
	//判断URL地址
	if(!filter_var($url, FILTER_VALIDATE_URL)) {
		echo 'URL地址不合法!';
		exit;
	}
	//清除缓存
	if($method == 'clear') {
		unlink($filename);
	}

	//如果文件存在
	if((is_file($filename)) && ($diff <= 1)) {
		$text = file_get_contents($filename);
	}
	//文件不存在
	else{
		$curl = curl_init($url);

	    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36");
	    curl_setopt($curl, CURLOPT_FAILONERROR, true);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

	    $text = curl_exec($curl);
	    curl_close($curl);
	    
	    $myfile = fopen($filename, "w");
	    fwrite($myfile, $text);
	    fclose($myfile);
	}
    
	$html = $Parsedown->text($text);

	//	是否带有样式
	switch ( $style )
	{
		case 'none':
			echo $html;
			break;		
		default:
			include_once('style.php');
			break;
	}
?>
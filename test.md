### GET方式
```php
<?php
	//初始化
　　$ch = curl_init();
　　//设置选项，包括URL
　　curl_setopt($ch, CURLOPT_URL, "http://www.jb51.net");
　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
　　curl_setopt($ch, CURLOPT_HEADER, 0);
　　//执行并获取HTML文档内容
　　$output = curl_exec($ch);
　　//释放curl句柄
　　curl_close($ch);
　　//打印获得的数据
　　print_r($output);
?>
```

### POST方式
```
<?php
	$url = "http://localhost/web_services.php";
　　$post_data = array ("username" => "bob","key" => "12345");
　　$ch = curl_init();
　　curl_setopt($ch, CURLOPT_URL, $url);
　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
　　// post数据
　　curl_setopt($ch, CURLOPT_POST, 1);
　　// post的变量
　　curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
　　$output = curl_exec($ch);
　　curl_close($ch);
　　//打印获得的数据
　　print_r($output);
?>
```
### HTTPS
```
<?php
    $curl = curl_init("https://www.xiaoz.me/");

    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)");
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $html = curl_exec($curl);
    curl_close($curl);
    var_dump($html);
?>
```

___

> 测试是否删除了缓存
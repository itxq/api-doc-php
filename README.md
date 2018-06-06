# api-doc-php

### 开源地址：

[GigHub https://github.com/itxq/api-doc-php](https://github.com/itxq/api-doc-php)

[码云 https://gitee.com/itxq/api-doc-php](https://github.com/itxq/api-doc-php)
    
    

### 主要功能：

+ 根据接口注释自动生成接口文档

### 扩展安装：

+ composer命令 `composer require itxq/wechat-sdk-php`

### 引用扩展：

+ 当你的项目不支持composer自动加载时，可以使用以下方式来引用该扩展包

`require_once __DIR__ . '/vendor/autoload.php'`

### 使用扩展：

```
// 引入SDK
require_once __DIR__ . '/vendor/autoload.php';

// 配置信息
$config = [
    'class'         => ['Api', 'Api2'], // 要生成文档的类
    'filter_method' => ['__construct', 'add', 'edit'], // 要过滤的方法名称
];

// 调用
$api = new \itxq\apidoc\ApiDoc($config);
$doc = $api->getApiDoc();
echo '<pre>';
var_dump($doc);
echo '</pre>';
```
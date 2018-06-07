<?php
/**
 *  ==================================================================
 *        文 件 名: index.php
 *        概    要: API文档 By Api-Doc-PHP
 *        作    者: IT小强
 *        创建时间: 2018/6/5 9:48
 *        修改时间:
 *        copyright (c) 2016 - 2018 mail@xqitw.cn
 *  ==================================================================
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Api.php'; // 加载测试API类1
require_once __DIR__ . '/Api2.php'; // 加载测试API类2
$config = [
    'class'         => ['Api', 'Api2'], // 要生成文档的类
    'filter_method' => ['__construct'], // 要过滤的方法名称
];
$api = new \itxq\apidoc\BootstrapApiDoc($config);
$doc = $api->getHtml();
exit($doc);


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
$api = new \itxq\apidoc\ApiDoc($config);
$doc = $api->getApiDoc();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <!-- 禁止浏览器初始缩放 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=0">
    <title>API文档 By Api-Doc-PHP</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .class-item .class-title {
            text-indent: 0.6em;
            border-left: 5px solid lightseagreen;
            font-size: 24px;
            margin: 10px 0;
        }
        
        .action-item .action-title {
            text-indent: 0.6em;
            border-left: 3px solid #F0AD4E;
            font-size: 20px;
            margin: 8px 0;
        }
        
        .table-item {
            background-color: #F1F1F1;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php foreach ($doc as $className => $classItem) { ?>
        <div class="row">
            <div class="class-item col-md-12" id="<?php echo $className; ?>">
                <h2 class="class-title">
                    <?php echo $classItem['title']; ?>
                </h2>
                <hr>
                <?php foreach ($classItem['action'] as $actionName => $actionItem) { ?>
                    <div class="action-item  col-md-12" id="<?php echo $className; ?>-<?php echo $actionName; ?>">
                        <h4 class="action-title">API - <?php echo $actionItem['title']; ?></h4>
                        <p>请求方式：
                            <span class="btn btn-info btn-sm"><?php echo $actionItem['method']; ?></span>
                        </p>
                        <p>请求地址：<a href="<?php echo $actionItem['url']; ?>"><?php echo $actionItem['url']; ?></a></p>
                        <div class="table-item col-md-12">
                            <p class="table-title"><span class="btn  btn-sm btn-danger">body参数</span></p>
                            <table class="table">
                                <tr>
                                    <td>参数</td>
                                    <td>类型</td>
                                    <td>描述</td>
                                    <td>默认值</td>
                                    <td>是否必须</td>
                                </tr>
                                <?php foreach ($actionItem['param'] as $param) { ?>
                                    <tr>
                                        <td><?php echo $param['param_name']; ?></td>
                                        <td><?php echo $param['param_type']; ?></td>
                                        <td><?php echo $param['param_title']; ?></td>
                                        <td><?php echo $param['param_default']; ?></td>
                                        <td><?php echo $param['param_require']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="table-item col-md-12">
                            <p class="table-title"><span class="btn  btn-sm btn-warning">状态码说明</span></p>
                            <table class="table">
                                <tr>
                                    <td>状态码</td>
                                    <td>描述</td>
                                </tr>
                                <?php foreach ($actionItem['code'] as $code) { ?>
                                    <tr>
                                        <td><?php echo $code['code']; ?></td>
                                        <td><?php echo $code['content']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="table-item col-md-12">
                            <p class="table-title"><span class="btn  btn-sm btn-success">返回参数</span></p>
                            <table class="table">
                                <tr>
                                    <td>参数</td>
                                    <td>类型</td>
                                    <td>描述</td>
                                </tr>
                                <?php foreach ($actionItem['return'] as $return) { ?>
                                    <tr>
                                        <td><?php echo $return['return_name']; ?></td>
                                        <td><?php echo $return['return_type']; ?></td>
                                        <td><?php echo $return['return_title']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>


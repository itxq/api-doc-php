<?php
/**
 *  ==================================================================
 *        文 件 名: BootstrapApiDoc.php
 *        概    要: BootstrapAPI文档生成
 *        作    者: IT小强
 *        创建时间: 2018/6/6 13:57
 *        修改时间:
 *        copyright (c) 2016 - 2018 mail@xqitw.cn
 *  ==================================================================
 */

namespace itxq\apidoc;

use itxq\apidoc\lib\Tools;

/**
 * BootstrapAPI文档生成
 * Class BootstrapApiDoc
 * @package itxq\apidoc
 */
class BootstrapApiDoc extends ApiDoc
{
    /**
     * @var string - Bootstrap CSS文件路径
     */
    private $bootstrapCss = __DIR__ . '/../assets/css/bootstrap.min.css';
    
    /**
     * @var string - Bootstrap JS文件路径
     */
    private $bootstrapJs = __DIR__ . '/../assets/js/bootstrap.min.js';
    
    /**
     * @var string - jQuery Js文件路径
     */
    private $jQueryJs = __DIR__ . '/../assets/js/jquery.min.js';
    
    /**
     * @var string - 自定义CSS
     */
    private $customCss = '<style type="text/css">
        ::-webkit-scrollbar {width: 5px;}
        .navbar-collapse.collapse.show::-webkit-scrollbar {width: 0; height: 0;background-color: rgba(255, 255, 255, 0);}
        ::-webkit-scrollbar-track {background-color: rgba(255, 255, 255, 0.2);-webkit-border-radius: 2em;-moz-border-radius: 2em;border-radius: 2em;}
        ::-webkit-scrollbar-thumb {background-color: rgba(0, 0, 0, 0.8);-webkit-border-radius: 2em;-moz-border-radius: 2em;border-radius: 2em;}
        ::-webkit-scrollbar-button {-webkit-border-radius: 2em;-moz-border-radius: 2em;border-radius: 2em;height: 0;background-color: rgba(0, 0, 0, 0.9);}
        ::-webkit-scrollbar-corner {background-color: rgba(0, 0, 0, 0.9);}
        #list-tab-left-nav{display: none;}
        .doc-content{margin-top: 75px;}
        .class-item .class-title {text-indent: 0.6em;border-left: 5px solid lightseagreen;font-size: 24px;margin: 15px 0;}
        .action-item .action-title {text-indent: 0.6em;border-left: 3px solid #F0AD4E;font-size: 20px;margin: 8px 0;}
        .table-item {background-color:#FFFFFF;padding-top: 10px;margin-bottom:10px;border: solid 1px #ccc;border-radius: 5px;}
        .list-group-item-sub{padding: .5rem 1.25rem;}
        .copyright-content{margin: 10px 0;}
    </style>';
    
    /**
     * @var string - 自定义JS
     */
    private $customJs = '<script type="text/javascript">
         $(\'a[href*="#"]:not([href="#"])\').click(function() {
            if (location.pathname.replace(/^\//, \'\') == this.pathname.replace(/^\//, \'\') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $("[name=\' + this.hash.slice(1) +\']");
                if (target.length) {
                    var topOffset = target.offset().top - 60;
                    $("html, body").animate({
                        scrollTop: topOffset
                    }, 800);
                    return false;
                }
            }
        });
    </script>';
    
    /**
     * Bootstrap 构造函数.
     * @param array $config - 配置信息
     */
    public function __construct($config) {
        parent::__construct($config);
        // bootstrapJs文件路径
        $this->bootstrapJs = Tools::getSubValue('bootstrap_js', $config, $this->bootstrapJs);
        // jQueryJs文件路径
        $this->jQueryJs = Tools::getSubValue('jquery_js', $config, $this->jQueryJs);
        // 自定义js
        $this->customJs .= Tools::getSubValue('custom_js', $config, '');
        // bootstrapCSS文件路径
        $this->bootstrapCss = Tools::getSubValue('bootstrap_css', $config, $this->bootstrapCss);
        // 自定义CSS
        $this->customCss .= Tools::getSubValue('custom_css', $config, '');
        // 合并CSS
        $this->_getCss();
        // 合并JS
        $this->_getJs();
    }
    
    /**
     * 输出HTML
     * @param int $type - 方法过滤，默认只获取 public类型 方法
     * ReflectionMethod::IS_STATIC
     * ReflectionMethod::IS_PUBLIC
     * ReflectionMethod::IS_PROTECTED
     * ReflectionMethod::IS_PRIVATE
     * ReflectionMethod::IS_ABSTRACT
     * ReflectionMethod::IS_FINAL
     * @return string
     */
    public function getHtml($type = \ReflectionMethod::IS_PUBLIC) {
        $data = $this->getApiDoc($type);
        $html = <<<EXT
        <!DOCTYPE html>
        <html lang="zh-CN">
        <head>
            <meta charset="utf-8">
            <meta name="renderer" content="webkit">
            <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
            <!-- 禁止浏览器初始缩放 -->
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=0">
            <title>API文档 By Api-Doc-PHP</title>
            {$this->customCss}
        </head>
        <body>
        <div class="container-fluid">
             <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
                   <a class="navbar-brand" href="#">API文档</a>
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" >
                       <span class="navbar-toggler-icon"></span>
                   </button>
                   <div class="collapse navbar-collapse" id="navbarColor01">
                        {$this->_getTopNavList($data)}
                   </div>
             </nav>
             <div class="row">
                    <div class="col-lg-12">{$this->_getDocList($data)}</div>
                </div>
             <div class="row">
                    <div class="col-lg-12 text-center copyright-content">
                        Copyright  2016 - 2018 <a href="http://www.xqitw.cn">小强IT屋</a> 版权所有
                    </div>
                </div>
        </div>
        {$this->customJs}
        </body>
        </html>
EXT;
        
        if (isset($_GET['download']) && $_GET['download'] === 'api_doc_php') {
            Tools::downloadFile($html);
            return true;
        }
        return $html;
    }
    
    /**
     * 解析return 并生成HTML
     * @param array $data
     * @return string
     */
    private function _getReturnData($data = []) {
        $html = '';
        if (!is_array($data) || count($data) < 1) {
            return $html;
        }
        $html .= '<div class="table-item col-md-12"><p class="table-title"><span class="btn  btn-sm btn-success">返回参数</span></p>';
        $html .= '<table class="table"><tr><td>参数</td><td>类型</td><td>描述</td></tr>';
        foreach ($data as $v) {
            $html .= '<tr>
                        <td>' . Tools::getSubValue('return_name', $v, '') . '</td>
                        <td>' . Tools::getSubValue('return_type', $v, '') . '</td>
                        <td>' . Tools::getSubValue('return_title', $v, '') . '</td>
                      </tr>';
        }
        $html .= '</table></div>';
        return $html;
    }
    
    /**
     * 解析param 并生成HTML
     * @param array $data
     * @return string
     */
    private function _getParamData($data = []) {
        $html = '';
        if (!is_array($data) || count($data) < 1) {
            return $html;
        }
        $html .= '<div class="table-item col-md-12"><p class="table-title"><span class="btn  btn-sm btn-danger">请求参数</span></p>';
        $html .= '<table class="table"><tr><td>参数</td><td>类型</td><td>描述</td><td>默认值</td><td>是否必须</td></tr>';
        foreach ($data as $v) {
            $html .= '<tr>
                        <td>' . Tools::getSubValue('param_name', $v, '') . '</td>
                        <td>' . Tools::getSubValue('param_type', $v, '') . '</td>
                        <td>' . Tools::getSubValue('param_title', $v, '') . '</td>
                        <td>' . Tools::getSubValue('param_default', $v, '无默认值') . '</td>
                        <td>' . Tools::getSubValue('param_require', $v, '非必须') . '</td>
                      </tr>';
        }
        $html .= '</table></div>';
        return $html;
    }
    
    /**
     * 解析code 并生成HTML
     * @param array $data
     * @return string
     */
    private function _getCodeData($data = []) {
        $html = '';
        if (!is_array($data) || count($data) < 1) {
            return $html;
        }
        $html .= '<div class="table-item col-md-12"><p class="table-title"><span class="btn  btn-sm btn-warning">状态码说明</span></p>';
        $html .= '<table class="table"><tr><td>状态码</td><td>描述</td></tr>';
        foreach ($data as $v) {
            $html .= '<tr>
                        <td>' . Tools::getSubValue('code', $v, '') . '</td>
                        <td>' . Tools::getSubValue('content', $v, '暂无说明') . '</td>
                      </tr>';
        }
        $html .= '</table></div>';
        return $html;
    }
    
    /**
     * 获取指定接口操作下的文档信息
     * @param $className - 类名
     * @param $actionName - 操作名
     * @param $actionItem - 接口数据
     * @return string
     */
    private function _getActionItem($className, $actionName, $actionItem) {
        $html = <<<EXT
                <div class="list-group-item list-group-item-action action-item  col-md-12" id="{$className}_{$actionName}">
                    <h4 class="action-title">API - {$actionItem['title']}</h4>
                    <p>请求方式：
                        <span class="btn btn-info btn-sm">{$actionItem['method']}</span>
                    </p>
                    <p>请求地址：<a href="{$actionItem['url']}">{$actionItem['url']}</a></p>
                    {$this->_getParamData(Tools::getSubValue('param', $actionItem, []))}
                    {$this->_getReturnData(Tools::getSubValue('return', $actionItem, []))}
                    {$this->_getCodeData(Tools::getSubValue('code', $actionItem, []))}
                </div>
EXT;
        return $html;
    }
    
    /**
     * 获取指定API类的文档HTML
     * @param $className - 类名称
     * @param $classItem - 类数据
     * @return string
     */
    private function _getClassItem($className, $classItem) {
        $title = Tools::getSubValue('title', $classItem, '未命名');
        $actionHtml = '';
        if (isset($classItem['action']) && is_array($classItem['action']) && count($classItem['action']) >= 1) {
            foreach ($classItem['action'] as $actionName => $actionItem) {
                $actionHtml .= $this->_getActionItem($className, $actionName, $actionItem);
            }
        }
        $html = <<<EXT
                    <div class="class-item" id="{$className}">
                        <h2 class="class-title">{$title}</h2>
                        <div class="list-group">{$actionHtml}</div>
                    </div>
EXT;
        return $html;
    }
    
    /**
     * 获取API文档HTML
     * @param array $data - 文档数据
     * @return string
     */
    private function _getDocList($data) {
        $html = '';
        if (count($data) < 1) {
            return $html;
        }
        $html .= '<div class="doc-content">';
        foreach ($data as $className => $classItem) {
            $html .= $this->_getClassItem($className, $classItem);
        }
        $html .= '</div>';
        return $html;
    }
    
    /**
     * 获取顶部导航HTML
     * @param $data -API文档数据
     * @return string
     */
    private function _getTopNavList($data) {
        $html = '<ul class="navbar-nav" id="navbar-nav-top-nav">';
        foreach ($data as $className => $classItem) {
            $title = Tools::getSubValue('title', $classItem, '未命名');
            $html .= '<li class="nav-item dropdown">';
            $html .= '<a class="nav-link dropdown-toggle" href="#" id="' . $className . '-nav" data-toggle="dropdown">' . $title . '</a>';
            $html .= '<div class="dropdown-menu" aria-labelledby="' . $className . '-nav">';
            foreach ($classItem['action'] as $actionName => $actionItem) {
                $title = Tools::getSubValue('title', $actionItem, '未命名');
                $id = $className . '_' . $actionName;
                $html .= '<a class="dropdown-item" href="#' . $id . '">' . $title . '</a>';
            }
            $html .= '</div></li>';
        }
        if (!isset($_GET['download']) || $_GET['download'] !== 'api_doc_php') {
            $html .= ' <li class="nav-item"><a class="nav-link" href="?download=api_doc_php">下载文档</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
    
    /**
     * 获取文档CSS
     * @return string
     */
    private function _getCss() {
        $path = realpath($this->bootstrapCss);
        if (!$path || !is_file($path)) {
            return $this->customCss;
        }
        $bootstrapCss = file_get_contents($path);
        if (empty($bootstrapCss)) {
            return $this->customCss;
        }
        $this->customCss = '<style type="text/css">' . $bootstrapCss . '</style>' . $this->customCss;
        // $this->customCss = ' <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">' . $this->customCss;
        return $this->customCss;
    }
    
    /**
     * 获取文档JS
     * @return string
     */
    private function _getJs() {
        //  $js = '<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>';
        //  $js .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>';
        //  $this->customJs = $js . $this->customJs;
        //  return $this->customJs;
        $bootstrapJs = realpath($this->bootstrapJs);
        $jQueryJs = realpath($this->jQueryJs);
        if (!$bootstrapJs || !$jQueryJs || !is_file($bootstrapJs) || !is_file($jQueryJs)) {
            $this->customJs = '';
            return $this->customCss;
        }
        $bootstrapJs = file_get_contents($bootstrapJs);
        $jQueryJs = file_get_contents($jQueryJs);
        if (empty($bootstrapJs) || empty($jQueryJs)) {
            $this->customJs = '';
            return $this->customJs;
        }
        $js = '<script type="text/javascript">' . $jQueryJs . '</script>' . '<script type="text/javascript">' . $bootstrapJs . '</script>';
        $this->customJs = $js . $this->customJs;
        return $this->customJs;
    }
}
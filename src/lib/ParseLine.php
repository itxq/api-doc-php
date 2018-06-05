<?php
/**
 *  ==================================================================
 *        文 件 名: ParseLine.php
 *        概    要: 按行解析注释参数
 *        作    者: IT小强
 *        创建时间: 2018/6/5 10:34
 *        修改时间:
 *        copyright (c) 2016 - 2018 mail@xqitw.cn
 *  ==================================================================
 */

namespace itxq\apidoc\lib;

/**
 * 按行解析注释参数
 * Class ParseLine
 * @package itxq\apidoc\lib
 */
class ParseLine
{
    /**
     * 解析 title|url
     * @param $line
     * @return array
     */
    public function parseLineTitle($line) {
        return ['type' => $line[0], 'content' => $line[1]];
    }
    
    /**
     * 解析param
     * @param $line
     * @return array
     */
    public function parseLineParam($line) {
        return [
            'type'          => 'param',
            'param_type'    => $line[1],
            'param_name'    => $line[2],
            'param_title'   => $line[3],
            'param_default' => isset($line[4]) ? $line[4] : '无',
        ];
    }
    
    /**
     * 下划线命名转驼峰命名
     * @param $str - 下划线命名字符串
     * @param $is_first - 是否为大驼峰（即首字母也大写）
     * @return mixed
     */
    public function underlineToHump($str, $is_first = false) {
        $str = preg_replace_callback('/([\-\_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        if ($is_first) {
            $str = ucfirst($str);
        }
        return $str;
    }
    
    /**
     * 驼峰命名转下划线命名
     * @param $str
     * @return mixed
     */
    public function humpToUnderline($str) {
        $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        $str = preg_replace('/^\_/', '', $str);
        return $str;
    }
}
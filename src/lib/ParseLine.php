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
     * 解析 param
     * @param $line
     * @return array
     */
    public function parseLineParam($line) {
        return [
            'type'          => $line[0],
            'param_type'    => $line[1],
            'param_name'    => $line[2],
            'param_title'   => $line[3],
            'param_default' => $line[4],
            'param_require' => $line[5],
        ];
    }
    
    /**
     * 解析 code
     * @param $line
     * @return array
     */
    public function parseLineCode($line) {
        return [
            'type'    => $line[0],
            'code'    => $line[1],
            'content' => isset($line[2]) ? $line[2] : '',
        ];
    }
    
    /**
     * 解析 return
     * @param $line
     * @return array
     */
    public function parseLineReturn($line) {
        return [
            'type'         => $line[0],
            'return_type'  => $line[1],
            'return_name'  => $line[2],
            'return_title' => isset($line[3]) ? $line[3] : '',
        ];
    }
}
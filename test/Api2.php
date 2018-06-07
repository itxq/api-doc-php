<?php
/**
 *  ==================================================================
 *        文 件 名: Api2.php
 *        概    要:
 *        作    者: IT小强
 *        创建时间: 2018/6/6 9:17
 *        修改时间:
 *        copyright (c) 2016 - 2018 mail@xqitw.cn
 *  ==================================================================
 */

/**
 * @title 用户相关
 * Class Api
 */
class Api2
{
    /**
     * @title 获取用户信息
     * @url https://wwww.baidu.com/getuserinfo
     * @method GET
     * @param int uid 用户ID 0 必须
     * @param string token 令牌 空 必须
     * @code 1 成功
     * @code 2 失败
     * @return int code 状态码（具体参见状态码说明）
     * @return string msg 提示信息
     */
    public function getUserInfo() {
        return json_encode(['code' => 1, 'msg' => '获取信息成功', 'data' => ['uid' => 1, 'username' => 'admin']]);
    }
}
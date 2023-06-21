<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: symongroup <xiaobo.sun@qq.com>
// +----------------------------------------------------------------------

namespace symongroup\pay\interfaces;

interface Refundable
{
    public function getRefundNo();

    public function getExtra($name);

    public function getAmount();

    public function getChannel();

    /**
     * @return Payable
     */
    public function getCharge();
  
}
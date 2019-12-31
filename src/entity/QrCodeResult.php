<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace yunwuxin\pay\entity;

class QrCodeResult
{
    protected $codeUrl;

    public function __construct($codeUrl)
    {
        $this->codeUrl = $codeUrl;
    }

    public function getCodeUrl()
    {
        return $this->codeUrl;
    }

    public function __toString()
    {
        return $this->codeUrl;
    }
}
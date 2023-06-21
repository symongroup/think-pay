<?php

namespace symongroup\pay\facade;

use think\Facade;

class Payment extends Facade
{
    protected static function getFacadeClass()
    {
        return \symongroup\pay\Payment::class;
    }
}

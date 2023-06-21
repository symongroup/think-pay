<?php
// +----------------------------------------------------------------------
// | ThinkPay
// +----------------------------------------------------------------------
// | Copyright (c) symongroup All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: symongroup <xiaobo.sun@qq.com>
// +----------------------------------------------------------------------

namespace symongroup\pay;

use symongroup\pay\entity\PurchaseResponse;
use symongroup\pay\interfaces\Payable;

abstract class Gateway
{

    /** @var Channel */
    protected $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * 付款
     * @param Payable $charge
     * @return PurchaseResponse
     */
    abstract public function purchase(Payable $charge);

}

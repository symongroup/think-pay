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

namespace symongroup\pay\gateway\alipay;

use symongroup\pay\entity\PurchaseResponse;
use symongroup\pay\Gateway;
use symongroup\pay\interfaces\Payable;
use symongroup\pay\request\alipay\TradeAppPayRequest;

class App extends Gateway
{

    /**
     * 购买
     * @param Payable $charge
     * @return PurchaseResponse
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(TradeAppPayRequest::class, $charge);
        return new PurchaseResponse(parse_url($request->getUri(), PHP_URL_QUERY), PurchaseResponse::TYPE_PARAMS);
    }
}

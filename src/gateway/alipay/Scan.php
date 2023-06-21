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
use symongroup\pay\request\alipay\TradePreCreateRequest;

class Scan extends Gateway
{

    /**
     * 购买
     * @param Payable $charge
     * @return PurchaseResponse
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(TradePreCreateRequest::class, $charge);

        $result = $this->channel->sendRequest($request);

        return new PurchaseResponse($result['qr_code'], PurchaseResponse::TYPE_SCAN);
    }
}

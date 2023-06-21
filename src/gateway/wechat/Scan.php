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

namespace symongroup\pay\gateway\wechat;

use symongroup\pay\channel\Wechat;
use symongroup\pay\entity\PurchaseResponse;
use symongroup\pay\Gateway;
use symongroup\pay\interfaces\Payable;
use symongroup\pay\request\wechat\UnifiedOrderRequest;

class Scan extends Gateway
{

    /**
     * 购买
     * @param Payable $charge
     * @return PurchaseResponse
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(UnifiedOrderRequest::class, $charge, Wechat::TYPE_NATIVE);

        $result = $this->channel->sendRequest($request);

        return new PurchaseResponse($result['code_url'], PurchaseResponse::TYPE_SCAN);
    }
}

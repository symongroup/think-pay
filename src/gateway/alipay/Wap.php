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
use symongroup\pay\request\alipay\TradeWapPayRequest;

/**
 * 手机网站支付网关
 * Class Wap
 * @package symongroup\pay\channel\alipay\gateway
 */
class Wap extends Gateway
{

    /**
     * 购买
     * @param Payable $charge
     * @return PurchaseResponse
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(TradeWapPayRequest::class, $charge);

        return new PurchaseResponse($request->getUri(), PurchaseResponse::TYPE_REDIRECT);
    }
}

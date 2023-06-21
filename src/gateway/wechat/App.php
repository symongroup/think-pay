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

use think\helper\Str;
use symongroup\pay\channel\Wechat;
use symongroup\pay\entity\PurchaseResponse;
use symongroup\pay\Gateway;
use symongroup\pay\interfaces\Payable;
use symongroup\pay\request\wechat\UnifiedOrderRequest;

class App extends Gateway
{

    /**
     * 购买
     * @param Payable $charge
     * @return PurchaseResponse
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(UnifiedOrderRequest::class, $charge, Wechat::TYPE_APP);

        $result = $this->channel->sendRequest($request);

        $data = [
            'appid'     => $this->channel->getOption('app_id'),
            'partnerid' => $this->channel->getOption('mch_id'),
            'prepayid'  => $result['prepay_id'],
            'package'   => 'Sign=WXPay',
            'noncestr'  => Str::random(),
            'timestamp' => (string) time(),
        ];

        $data['sign'] = $this->channel->generateSign($data);

        return new PurchaseResponse($data, PurchaseResponse::TYPE_PARAMS);
    }
}

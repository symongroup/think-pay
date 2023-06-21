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

class Js extends Gateway
{

    /**
     * 购买
     * @param Payable $charge
     * @return PurchaseResponse
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(UnifiedOrderRequest::class, $charge, Wechat::TYPE_JSAPI);

        $result = $this->channel->sendRequest($request);

        $data = [
            'appId'     => $this->channel->getOption('app_id'),
            'timeStamp' => (string) time(),
            'nonceStr'  => Str::random(),
            'package'   => "prepay_id={$result['prepay_id']}",
            'signType'  => 'MD5',
        ];

        $data['paySign'] = $this->channel->generateSign($data);

        return new PurchaseResponse($data, PurchaseResponse::TYPE_PARAMS);
    }
}

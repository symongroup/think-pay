<?php

namespace symongroup\pay\gateway\wechat;

use symongroup\pay\channel\Wechat;
use symongroup\pay\entity\PurchaseResponse;
use symongroup\pay\Gateway;
use symongroup\pay\interfaces\Payable;
use symongroup\pay\request\wechat\UnifiedOrderRequest;

class Wap extends Gateway
{

    /**
     * @inheritDoc
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(UnifiedOrderRequest::class, $charge, Wechat::TYPE_MWEB);

        $result = $this->channel->sendRequest($request);

        return new PurchaseResponse($result['mweb_url'], PurchaseResponse::TYPE_REDIRECT);
    }
}

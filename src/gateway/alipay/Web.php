<?php

namespace symongroup\pay\gateway\alipay;

use symongroup\pay\entity\PurchaseResponse;
use symongroup\pay\Gateway;
use symongroup\pay\interfaces\Payable;
use symongroup\pay\request\alipay\TradePagePayRequest;

class Web extends Gateway
{

    /**
     * @inheritDoc
     */
    public function purchase(Payable $charge)
    {
        $request = $this->channel->createRequest(TradePagePayRequest::class, $charge);

        return new PurchaseResponse($request->getUri(), PurchaseResponse::TYPE_REDIRECT);
    }
}

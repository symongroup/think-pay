<?php

namespace symongroup\pay\request\alipay;

use symongroup\pay\interfaces\Payable;

class TradeQueryRequest extends Request
{
    protected $method = 'alipay.trade.query';

    public function __invoke(Payable $payable)
    {
        $this->bizContent = [
            'out_trade_no' => $payable->getTradeNo(),
        ];
    }
}

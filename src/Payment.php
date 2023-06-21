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

use InvalidArgumentException;
use think\helper\Arr;
use think\Manager;
use symongroup\pay\interfaces\Payable;

class Payment extends Manager
{
    protected $namespace = '\\symongroup\\pay\\channel\\';

    public function gateway(string $name)
    {
        [$channel, $gateway] = explode('.', $name, 2);
        return $this->channel($channel)->gateway($gateway);
    }

    /**
     * @param string $name
     * @return Channel
     */
    public function channel(string $name)
    {
        return $this->driver($name);
    }

    public function getConfig(string $name = null, $default = null)
    {
        if (!is_null($name)) {
            return $this->app->config->get('pay.' . $name, $default);
        }

        return $this->app->config->get('pay');
    }

    public function getChannelConfig($channel, $name = null, $default = null)
    {
        if ($config = $this->getConfig("channels.{$channel}")) {
            return Arr::get($config, $name, $default);
        }

        throw new InvalidArgumentException("Channel [$channel] not found.");
    }

    protected function resolveType(string $name)
    {
        return $this->getChannelConfig($name, 'type');
    }

    protected function resolveConfig(string $name)
    {
        return Arr::except($this->getChannelConfig($name), 'type');
    }

    protected function createDriver(string $name)
    {
        /** @var Channel $channel */
        $channel = parent::createDriver($name);
        $channel->setName($name);

        $notifyUrl = $this->getConfig('notify_url') ?: url('PAY_NOTIFY', ['channel' => $name])->domain(true);
        $channel->setNotifyUrl((string) $notifyUrl);

        if ($this->getConfig('sandbox')) {
            $channel->setSandbox();
        }

        $channel->setChargeResolver(function ($tradeNo) {
            /** @var Payable $charge */
            $charge = $this->getConfig('charge');

            return $charge::retrieveByTradeNo($tradeNo);
        });

        return $channel;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultDriver()
    {
        return null;
    }
}

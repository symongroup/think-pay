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

use Closure;
use GuzzleHttp\Client;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use think\helper\Str;
use think\Request;
use symongroup\pay\entity\PurchaseResult;
use symongroup\pay\interfaces\Payable;
use symongroup\pay\interfaces\Refundable;

abstract class Channel
{

    /** @var Closure */
    protected $chargeResolver;

    /** @var Client */
    protected $httpClient;

    protected $notifyUrl;

    protected $options;

    protected $sandbox = false;

    protected $name;

    public function __construct($options = [])
    {
        $resolver = new OptionsResolver();

        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        $this->httpClient = new Client($this->getHttpClientConfig());
    }

    protected function getHttpClientConfig()
    {
        return [
            'connect_timeout' => 5,
            'timeout'         => 5,
        ];
    }

    public function getOption($name)
    {
        return $this->options[$name] ?? null;
    }

    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    abstract protected function configureOptions(OptionsResolver $resolver);

    public function createRequest($class, ...$args)
    {
        /** @var \symongroup\pay\Request $request */
        $request = new $class($this);

        ($request)(...$args);

        return $request;
    }

    /**
     * @param \symongroup\pay\Request $request
     * @return mixed
     */
    public function sendRequest(\symongroup\pay\Request $request)
    {
        $request = $request->toPsrRequest();

        $response = $this->httpClient->sendRequest($request);

        return $this->handleResponse($request, $response);
    }

    public function gateway($name)
    {
        $channel   = class_basename($this);
        $className = "\\symongroup\\pay\\gateway\\" . Str::camel($channel) . "\\" . Str::studly($name);
        if (class_exists($className)) {
            /** @var Gateway $gateway */
            $gateway = new $className($this);

            return $gateway;
        }
        throw new InvalidArgumentException("Gateway [{$name}] not supported.");
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function setNotifyUrl(string $notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        return $this;
    }

    abstract public function verifySign($data, $sign);

    abstract public function generateSign(array $params): string;

    abstract protected function handleResponse(RequestInterface $request, ResponseInterface $response);

    public function setSandbox()
    {
        $this->sandbox = true;
        return $this;
    }

    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * 退款
     * @param Refundable $refund
     */
    abstract public function refund(Refundable $refund);

    /**
     * 退款查询
     * @param Refundable $refund
     * @return mixed
     */
    abstract public function refundQuery(Refundable $refund);

    /**
     * 查询
     * @param Payable $charge
     * @return PurchaseResult
     */
    abstract public function query(Payable $charge);

    abstract public function completePurchase(Request $request);

    public function setChargeResolver($resolver)
    {
        $this->chargeResolver = $resolver;
    }

    /**
     * @param $tradeNo
     * @return Payable
     */
    protected function retrieveCharge($tradeNo)
    {
        return ($this->chargeResolver)($tradeNo);
    }

}

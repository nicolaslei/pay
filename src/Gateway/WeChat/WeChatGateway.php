<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat;

use RocPay\Exception\TradeTypeNotExistException;
use RocPay\GatewayInterface;
use RocPay\Gateway\WeChat\Direct\App;
use RocPay\Gateway\WeChat\Direct\H5;
use RocPay\Gateway\WeChat\Direct\JsApi;
use RocPay\Gateway\WeChat\Direct\Native;

class WeChatGateway implements GatewayInterface
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function pay(array $data)
    {
        $tradeType = $data['trade_type'] ?? null;
        switch ($tradeType) {
            case 'app':
                $gateway = new App($this->config);
                break;
            case 'h5':
                $gateway = new H5($this->config);
                break;
            case 'jsapi':
                $gateway = new JsApi($this->config);
                break;
            case 'native':
                $gateway = new Native($this->config);
                break;
            default:
                throw new TradeTypeNotExistException('trade type non-existent');
        }

        return $gateway->pay($data);
    }

    public function refund()
    {
    }
}

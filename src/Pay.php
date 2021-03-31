<?php

declare(strict_types=1);

namespace RocPay;

use RocPay\Exception\GatewayNotExistException;
use RocPay\Gateway\Alipay\Config as AlipayConfig;
use RocPay\Gateway\WeChat\Config as WeChatConfig;
use RocPay\Gateway\WeChat\WeChatGateway;

class Pay
{
    public static function load(array $config): GatewayInterface
    {
        $platform = $config['platform'] ?? 'wechat';
        switch ($platform) {
            case 'wechat':
                return new WeChatGateway(
                    new WeChatConfig($config)
                );
            case 'alipay':
                break;
            default:
                throw new GatewayNotExistException();
        }
    }

    public static function weChat(WeChatConfig $config): GatewayInterface
    {
        return new WeChatGateway($config);
    }

    public static function alipay(AlipayConfig $config): GatewayInterface
    {
    }
}

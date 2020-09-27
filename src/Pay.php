<?php

declare(strict_types=1);

namespace RocPay;

use RocPay\Exception\GatewayNotExistException;
use RocPay\Gateway\Alipay\Config as AlipayConfig;
use RocPay\Gateway\WeChat\Config as WeCahtConfig;
use RocPay\Gateway\WeChat\WeChatGateway;

class Pay
{
    public static function load(array $config): GatewayInterface
    {
        $platform = $config['platform'] ?? 'wechat';
        switch ($platform) {
            case 'wechat':
                return new WeChatGateway(
                    new WeCahtConfig($config)
                );
                break;
            case 'alipay':
                break;
            default:
                throw new GatewayNotExistException();
        }
    }

    public static function weChat(WeCahtConfig $config): GatewayInterface
    {
        return new UnifiedService($config);
    }

    public static function alipay(AlipayConfig $config): GatewayInterface
    {
    }
}

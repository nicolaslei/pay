<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat\Direct;

use RocPay\Exception\InvalidRequestException;
use RocPay\Gateway\WeChat\AbstractPayDirect;
use RocPay\Gateway\WeChat\Config;
use RocPay\Gateway\WeChat\Traits\SceneInfoTrait;

class App extends AbstractPayDirect
{
    use SceneInfoTrait;

    public function __construct(Config $config)
    {
        $this->setParameter('appid', $config->getAppId());
        $this->setParameter('mchid', $config->getMchId());
        $this->setParameter('notify_url', $config->getNotifyUrl());
    }

    protected function getApiUri(): string
    {
        return '/pay/transactions/app';
    }

    /**
     * @throws InvalidRequestException
     */
    protected function parametersValidate()
    {
        $this->validate('appid', 'mchid', 'description', 'out_trade_no', 'notify_url', 'amount', 'scene_info');
    }
}
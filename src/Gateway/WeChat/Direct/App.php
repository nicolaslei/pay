<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat\Direct;

use RocPay\Gateway\WeChat\Client;
use RocPay\Gateway\WeChat\Config;
use RocPay\Gateway\WeChat\Traits\SceneInfoTrait;
use RocPay\ParametersTrait;

class App
{
    use SceneInfoTrait;
    use ParametersTrait;
   
    private $timeExpire;

    public function __construct(Config $config)
    {
        
    }

    public function pay($outTradeNo)
    {
        $client = new Client();
        $client->request();
    }

    /**
     * 示例值：2018-06-08T10:34:56+08:00
     */
    public function setTimeExpire(\DateTime $timeExpire): void
    {
        $this->setParameter('time_expire', $timeExpire->format("Y-m-d\TH:i:s+P"));
    }

    /**
     * [1,128]
     */
    public function setAttach(string $attach): void
    {

    }
}
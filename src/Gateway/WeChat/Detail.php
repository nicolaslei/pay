<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat;

use RocPay\Gateway\WeChat\ValueObject\Detail\H5Info;

class Detail
{
    private $payerClientIp;

    private $deviceId;

    private $storeInfo;

    /**
     * @var H5Info
     */
    private $h5Info;

    public function __construct()
    {
    }

    public function toJson()
    {

    }

    /**
     * @return mixed
     */
    public function getPayerClientIp()
    {
        return $this->payerClientIp;
    }

    /**
     * @param mixed $payerClientIp
     */
    public function setPayerClientIp($payerClientIp): void
    {
        $this->payerClientIp = $payerClientIp;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * @param mixed $deviceId
     */
    public function setDeviceId($deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @return mixed
     */
    public function getStoreInfo()
    {
        return $this->storeInfo;
    }

    /**
     * @param mixed $storeInfo
     */
    public function setStoreInfo($storeInfo): void
    {
        $this->storeInfo = $storeInfo;
    }

    /**
     * @return mixed
     */
    public function getH5Info()
    {
        return $this->h5Info;
    }

    /**
     * @param mixed $h5Info
     */
    public function setH5Info($h5Info): void
    {
        $this->h5Info = $h5Info;
    }
}
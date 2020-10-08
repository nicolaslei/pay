<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat\ValueObject\Detail;

use RocPay\Exception\InvalidRequestException;

class H5Info
{
    private $type;

    private $AppName;

    private $appUrl;

    private $bundleId;

    private $packageName;

    /**
     * H5Info constructor.
     * @param string $type
     * @param string $appName
     * @param string $appUrl
     * @param string $bundleId
     * @param string $packageName
     * @throws InvalidRequestException
     */
    public function __construct(
        string $type,
        string $appName = '',
        string $appUrl = '',
        string $bundleId = '',
        string $packageName = ''
    ) {
        $this->setType($type);
        $this->setAppName($appName);
        $this->setAppUrl($appUrl);
        $this->setBundleId($bundleId);
        $this->setPackageName($packageName);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws InvalidRequestException
     */
    public function setType(string $type): void
    {
        if (empty($type) || !in_array($type, ['IOS', 'Android', 'Wap'])) {
            throw new InvalidRequestException('H5场景信息场景类型错误');
        }
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getAppName()
    {
        return $this->AppName;
    }

    /**
     * @param mixed $AppName
     */
    public function setAppName($AppName): void
    {
        $this->AppName = $AppName;
    }

    /**
     * @return mixed
     */
    public function getAppUrl()
    {
        return $this->appUrl;
    }

    /**
     * @param mixed $appUrl
     */
    public function setAppUrl($appUrl): void
    {
        $this->appUrl = $appUrl;
    }

    /**
     * @return mixed
     */
    public function getBundleId()
    {
        return $this->bundleId;
    }

    /**
     * @param mixed $bundleId
     */
    public function setBundleId($bundleId): void
    {
        $this->bundleId = $bundleId;
    }

    /**
     * @return mixed
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @param mixed $packageName
     */
    public function setPackageName($packageName): void
    {
        $this->packageName = $packageName;
    }
}
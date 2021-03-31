<?php
/**
 * 当前文件功能说明
 * [XinFox System] Copyright (c) 2011 - 2021 XINFOX.CN
 */

declare(strict_types=1);

namespace RocPay\Gateway\WeChat;

use RocPay\Amount;
use RocPay\Exception\InvalidRequestException;
use RocPay\ParametersTrait;

/**
 * Class AbstractPayDirect
 * @package RocPay\Gateway\WeChat
 */
abstract class AbstractPayDirect
{
    use ParametersTrait;

    abstract protected function getApiUri(): string;
    abstract protected function parametersValidate();

    /**
     *
     * @param Amount $amount
     * @param mixed $outTradeNo 商户订单号
     * @param string $description 商品描述
     * @param string $notifyUrl
     * @throws InvalidRequestException
     */
    public function pay(Amount $amount, $outTradeNo, string $description, string $notifyUrl = '')
    {
        $this->setAmount($amount);
        $this->setOutTradeNo($outTradeNo);
        $this->setDescription($description);

        if (!empty($notifyUrl)) {
            $this->setNotifyUrl($notifyUrl);
        }

        $this->send();
    }

    public function send()
    {
        $uri = $this->getApiUri();
        $uri = '/' . ltrim($uri, '/'); // 兼容不以/开头
        $data = $this->getParameters();

        $client = new Client();
        $client->request('POST', $uri, [], $data);
    }

    /**
     * @param Amount $amount
     */
    public function setAmount(Amount $amount)
    {
        $this->setParameter('amount', $amount->toCent());
    }

    /**
     * @param string $notifyUrl
     */
    public function setNotifyUrl(string $notifyUrl)
    {
        $this->setParameter('notify_url', $notifyUrl);
    }

    /**
     * @param $outTradeNo
     * @throws InvalidRequestException
     */
    public function setOutTradeNo($outTradeNo)
    {
        if (!preg_match('/[0-9A-Za-z_\-\*]{6,32}/i', (string)$outTradeNo)) {
            throw new InvalidRequestException('商户订单号只能是数字、大小写字母_-*且唯一');
        }
        $this->setParameter('out_trade_no', $outTradeNo);
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->setParameter('description', $description);
    }

    /**
     * 交易结束时间
     * 订单失效时间，遵循rfc3339标准格式，
     * 格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，
     * TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）
     * 例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2018-06-08T10:34:56+08:00
     * @param \DateTime $timeExpire
     */
    public function setTimeExpire(\DateTime $timeExpire): void
    {
        $this->setParameter('time_expire', $timeExpire->format("Y-m-d\TH:i:sP"));
    }

    /**
     * 附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用
     * [1,128]
     * @param string $attach
     */
    public function setAttach(string $attach): void
    {
        $this->setParameter('attach', $attach);
    }

    /**
     * 优惠设置
     * @param Detail $detail
     */
    public function setDetail(Detail $detail)
    {
        $this->setParameter('detail', $detail);
    }

    /**
     * 设置结算信息
     * @param mixed $settleInfo
     */
    public function setSettleInfo($settleInfo)
    {
        $this->setParameter('settle_info', $settleInfo);
    }
}
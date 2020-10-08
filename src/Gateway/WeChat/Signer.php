<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat;

class Signer
{
    public static function sign($merchantId, $serialNo, $mchPrivateKey, $httpMethod, $url, $body)
    {
        $timestamp = time();
        $urlParts = parse_url($url);
        $canonical_url = ($urlParts['path'] . (!empty($urlParts['query']) ? "?${$urlParts['query']}" : ""));
        $message = $httpMethod."\n".
            $canonical_url."\n".
            $timestamp."\n".
            $nonce."\n".
            $body."\n";

        openssl_sign($message, $raw_sign, $mchPrivateKey, 'sha256WithRSAEncryption');
        $sign = base64_encode($raw_sign);

        $schema = 'WECHATPAY2-SHA256-RSA2048';
        $token = sprintf('mchid="%s",nonce_str="%s",timestamp="%d",serial_no="%s",signature="%s"',
            $merchantId, $nonce, $timestamp, $serialNo, $sign);
    }
}
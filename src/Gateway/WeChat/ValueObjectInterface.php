<?php

declare(strict_types=1);

namespace RocPay\Gateway\WeChat;

interface ValueObjectInterface
{
    public function toJson(): string;
}
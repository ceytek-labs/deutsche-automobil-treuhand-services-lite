<?php

namespace CeytekLabs\DeutscheAutomobilTreuhandServicesLite;

use CeytekLabs\DeutscheAutomobilTreuhandServicesLite\Services\Service;

class DAT
{
    private string $token;

    public static function make(string $token): self
    {
        $instance = new self;

        $instance->token = $token;

        return $instance;
    }

    public function service(): Service
    {
        return Service::make($this->token);
    }
}
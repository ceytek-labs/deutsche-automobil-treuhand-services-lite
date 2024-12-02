<?php

namespace CeytekLabs\DeutscheAutomobilTreuhandServicesLite\Services;

class Service
{
    private string $token;

    public static function make(string $token): self
    {
        $instance = new self;

        $instance->token = $token;

        return $instance;
    }

    public function vehicleIdentification(): VehicleIdentificationService
    {
        return VehicleIdentificationService::make($this->token);
    }

    public function vehicleSelection(): VehicleSelectionService
    {
        return VehicleSelectionService::make($this->token);
    }
}
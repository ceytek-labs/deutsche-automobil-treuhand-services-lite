<?php

namespace CeytekLabs\DeutscheAutomobilTreuhandServicesLite\Services;

class VehicleIdentificationService
{
    private string $token;
    
    private string $sessionId = '';
    
    private int $constructionTimeFrom = 1;
    
    private int $constructionTimeTo = 9999;
    
    private string $restriction = 'ALL';
    
    private string $vin;
    
    private string $coverage = 'ALL';
    
    private string $localeCountry;
    
    private string $localeDatCountryIndicator = 'DE';

    private string $localeLanguage;

    public static function make(string $token): self
    {
        $instance = new self;

        $instance->token = $token;

        return $instance;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function setConstructionTimeFrom(int $constructionTimeFrom): self
    {
        $this->constructionTimeFrom = $constructionTimeFrom;

        return $this;
    }

    public function setConstructionTimeTo(int $constructionTimeTo): self
    {
        $this->constructionTimeTo = $constructionTimeTo;

        return $this;
    }

    public function setRestriction(string $restriction): self
    {
        $this->restriction = $restriction;

        return $this;
    }

    public function setVin(string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function setCoverage(string $coverage): self
    {
        $this->coverage = $coverage;

        return $this;
    }

    public function setLocaleCountry(string $localeCountry): self
    {
        $this->localeCountry = $localeCountry;

        return $this;
    }

    public function setLocaleDatCountryIndicator(string $localeDatCountryIndicator): self
    {
        $this->localeDatCountryIndicator = $localeDatCountryIndicator;

        return $this;
    }

    public function setLocaleLanguage(string $localeLanguage): self
    {
        $this->localeLanguage = $localeLanguage;

        return $this;
    }

    public function get()
    {
        if (! isset($this->vin)) {
            throw new \Exception('Please set your VIN');
        }

        if (! isset($this->language)) {
            throw new \Exception('Please set your language');
        }

        if (! isset($this->country)) {
            throw new \Exception('Please set your country');
        }

        try {
            $client = new \SoapClient('https://www.dat.de/myClaim/soap/v2/VehicleIdentificationService?wsdl', [
                'trace' => 1,
                'stream_context' => stream_context_create([
                    'http' => [
                        'header' => "DAT-AuthorizationToken: {$this->token}",
                    ],
                ],)
            ]);
    
            $client->__setLocation('https://www.dat.de/myClaim/soap/v2/VehicleIdentificationService');
    
            $parameters = new \stdClass();
    
            $parameters->request = new \stdClass();
            $parameters->request->sessionID = $this->sessionId;
            $parameters->request->constructionTimeFrom = $this->constructionTimeFrom;
            $parameters->request->constructionTimeTo = $this->constructionTimeTo;
            $parameters->request->restriction = $this->restriction;
            $parameters->request->vin = $this->vin;
            $parameters->request->coverage = $this->coverage;
    
            $parameters->request->locale = new \stdClass();
            $parameters->request->locale->country = $this->localeCountry;
            $parameters->request->locale->datCountryIndicator = $this->localeDatCountryIndicator;
            $parameters->request->locale->language = $this->localeLanguage;
    
            return $client->getVehicleIdentificationByVin($parameters);
        } catch (\SoapFault $soapFault) {
            return $soapFault->getMessage();
        }
    }
}
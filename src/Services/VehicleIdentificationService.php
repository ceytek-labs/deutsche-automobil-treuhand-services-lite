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
    
    private string $country;
    
    private string $language;

    private string $datCountryIndicator = 'DE';

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

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setDatCountryIndicator(string $datCountryIndicator): self
    {
        $this->datCountryIndicator = $datCountryIndicator;

        return $this;
    }

    public static function make(string $token): self
    {
        $instance = new self;

        $instance->token = $token;

        return $instance;
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
            $parameters->request->locale->country = $this->country;
            $parameters->request->locale->datCountryIndicator = $this->datCountryIndicator;
            $parameters->request->locale->language = $this->language;
    
            return $client->getVehicleIdentificationByVin($parameters);
        } catch (\SoapFault $soapFault) {
            return $soapFault->getMessage();
        }
    }
}
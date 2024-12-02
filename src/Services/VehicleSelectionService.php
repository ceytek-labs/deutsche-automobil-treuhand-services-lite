<?php

namespace CeytekLabs\DeutscheAutomobilTreuhandServicesLite\Services;

class VehicleSelectionService
{
    private string $token;
    
    private string $sessionId = '';
    
    private string $restriction = 'ALL';
    
    private string $language = 'de_DE';

    private string $datECode;

    private string $container;

    private string $constructionTime;

    private string $localeCountry = 'DE';
    
    private string $localeDatCountryIndicator = 'DE';

    private string $localeLanguage = 'DE';

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

    public function setRestriction(string $restriction): self
    {
        $this->restriction = $restriction;

        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setDatECode(string $datECode): self
    {
        $this->datECode = $datECode;

        return $this;
    }

    public function setContainer(string $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function setConstructionTime(string $constructionTime): self
    {
        $this->constructionTime = $constructionTime;

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
        if (! isset($this->datECode)) {
            throw new \Exception('Please set your DAT E-Code');
        }

        if (! isset($this->container)) {
            throw new \Exception('Please set your container');
        }

        if (! isset($this->constructionTime)) {
            throw new \Exception('Please set your construction time');
        }

        try {
            $client = new \SoapClient('https://www.dat.de/myClaim/soap/v2/VehicleSelectionService?wsdl', [
                'trace' => 1,
                'stream_context' => stream_context_create([
                    'http' => [
                        'header' => "DAT-AuthorizationToken: {$this->token}",
                    ],
                ],)
            ]);
    
            $client->__setLocation('https://www.dat.de/myClaim/soap/v2/VehicleSelectionService');
    
            $parameters = new \stdClass();
    
            $parameters->request = new \stdClass();
            $parameters->request->sessionID = $this->sessionId;
            $parameters->request->restriction = $this->restriction;
            $parameters->request->language = $this->language;
            $parameters->request->datECode = $this->datECode;
            $parameters->request->container = $this->container;
            $parameters->request->constructionTime = $this->constructionTime;
    
            $parameters->request->locale = new \stdClass();
            $parameters->request->locale->country = $this->localeCountry;
            $parameters->request->locale->datCountryIndicator = $this->localeDatCountryIndicator;
            $parameters->request->locale->language = $this->localeLanguage;
    
            return $client->getVehicleData($parameters);
        } catch (\SoapFault $soapFault) {
            return $soapFault->getMessage();
        }
    }
}
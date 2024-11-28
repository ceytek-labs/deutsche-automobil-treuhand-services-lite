<?php

namespace CeytekLabs\DeutscheAutomobilTreuhandServicesLite;

class Login
{
    private int $customerNumber;

    private string $customerLogin;
    
    private string $customerPassword;

    private int $interfacePartnerNumber;
    
    private string $interfacePartnerSignature;

    public static function make(): self
    {
        return new self;
    }

    public function setCustomerNumber(int $customerNumber): self
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    public function setCustomerLogin(string $customerLogin): self
    {
        $this->customerLogin = $customerLogin;

        return $this;
    }

    public function setCustomerPassword(string $customerPassword): self
    {
        $this->customerPassword = $customerPassword;

        return $this;
    }

    public function setInterfacePartnerNumber(int $interfacePartnerNumber): self
    {
        $this->interfacePartnerNumber = $interfacePartnerNumber;

        return $this;
    }

    public function setInterfacePartnerSignature(string $interfacePartnerSignature): self
    {
        $this->interfacePartnerSignature = $interfacePartnerSignature;

        return $this;
    }

    public function generateToken(): string
    {
        if (! isset($this->customerNumber)) {
            throw new \Exception('Please set your customer number');
        }

        if (! isset($this->customerLogin)) {
            throw new \Exception('Please set your customer login');
        }

        if (! isset($this->customerPassword)) {
            throw new \Exception('Please set your customer password');
        }

        if (! isset($this->interfacePartnerNumber)) {
            throw new \Exception('Please set your interface partner number');
        }

        if (! isset($this->interfacePartnerSignature)) {
            throw new \Exception('Please set your interface partner signature');
        }

        $authWsdl = new \SoapClient('https://www.dat.de/myClaim/soap/v2/MyClaimExternalAuthenticationService?wsdl', [
            'features' => SOAP_WAIT_ONE_WAY_CALLS,
            'trace' => true,
            'exceptions' => 1,
            'cache_wsdl' => 'WSDL_CACHE_NONE',
            'encoding' => 'UTF-8',
            'uri' => 'https://www.dat.de/myClaim/soap/v2/MyClaimExternalAuthenticationService',
            'soap_version' => SOAP_1_1

        ]);

        $payload = new \SoapVar([
            'generateToken' => new \SoapVar("
                <request>
                    <customerNumber>{$this->customerNumber}</customerNumber>
                    <customerLogin>{$this->customerLogin}</customerLogin>
                    <customerPassword>{$this->customerPassword}</customerPassword>
                    <interfacePartnerNumber>{$this->interfacePartnerNumber}</interfacePartnerNumber>
                    <interfacePartnerSignature>{$this->interfacePartnerSignature}</interfacePartnerSignature>
                </request>
            ", XSD_ANYXML),
        ], SOAP_ENC_OBJECT);

        $generateToken = $authWsdl->__soapCall('generateToken', [$payload]);

        if (is_soap_fault($generateToken)) {
            throw new \Exception("DAT Login - Fault Code: {$generateToken->faultcode} | Fault String: {$generateToken->faultstring}");
        }

        return $generateToken->token;
    }
}
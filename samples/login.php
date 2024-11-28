<?php

use CeytekLabs\DeutscheAutomobilTreuhandServicesLite\Login;

$token = Login::make()
    ->setCustomerNumber('<customer-number>')
    ->setCustomerLogin('<customer-login>')
    ->setCustomerPassword('<customer-password>')
    ->setInterfacePartnerNumber('<interface-partner-number>')
    ->setInterfacePartnerSignature('<interface-partner-signature>')
    ->generateToken();
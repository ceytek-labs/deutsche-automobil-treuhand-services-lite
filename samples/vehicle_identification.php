<?php

use CeytekLabs\DeutscheAutomobilTreuhandServicesLite\DAT;

$dat = DAT::make('<your-token>')
    ->service()
    ->vehicleIdentification()
    ->setVin('<your-vin>')
    ->setLocaleLanguage('<language-code-lowecase>')
    ->setLocaleCountry('<country-code-uppercase>')
    ->get();

print_r($dat);
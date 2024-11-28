<?php

use CeytekLabs\DeutscheAutomobilTreuhandServicesLite\DAT;

$dat = DAT::make('<your-token>')
    ->service()
    ->vehicleIdentification()
    ->setVin('<your-vin>')
    ->setLanguage('<language-code-lowecase>')
    ->setCountry('<country-code-uppercase>')
    ->get();

print_r($dat);
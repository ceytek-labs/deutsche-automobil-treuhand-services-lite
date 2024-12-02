<?php

use CeytekLabs\DeutscheAutomobilTreuhandServicesLite\DAT;

$datVehicleSelection = DAT::make('<your-token>')
    ->service()
    ->vehicleSelection()
    ->setDatECode('<your-dat-e-code>')
    ->setContainer('<your-container>')
    ->setConstructionTime('<your-construction-time>')
    ->get();
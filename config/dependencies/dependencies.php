<?php

use Lucas\EmissorNotaFiscal\Helper\IssuerConfig;
use Lucas\EmissorNotaFiscal\Helper\NFeConfig;
use Lucas\EmissorNotaFiscal\Model\NFeBuilder;
use NFePHP\NFe\Make;
use Psr\Container\ContainerInterface;

return [
    NFeBuilder::class => function (ContainerInterface $c) {
        $make = new Make();
        $issuerConfig = new IssuerConfig();
        $config = new NFeConfig();

        return new NFeBuilder($make, $issuerConfig, $config);
    },
];

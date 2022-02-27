<?php

use Lucas\EmissorNotaFiscal\Helper\IssuerConfig;
use Lucas\EmissorNotaFiscal\Helper\NFeConfig;
use Lucas\EmissorNotaFiscal\Model\NFeBuilder;
use Lucas\EmissorNotaFiscal\Model\NFeSign;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Tools;
use NFePHP\NFe\Make;
use Psr\Container\ContainerInterface;

return [
    NFeBuilder::class => function (ContainerInterface $c) {
        $make = new Make();

        return new NFeBuilder($make, $c->get(IssuerConfig::class), $c->get(NFeConfig::class));
    },
    NFeSign::class => function (ContainerInterface $c) {
        $certificate = Certificate::readPfx($c->get('cert.url'), $c->get('cert.pass'));
        $tools = new Tools($c->get(NFeConfig::class), $certificate);

        return new NFeSign($tools, $c->get(IssuerConfig::class), $c->get(NFeConfig::class));
    },
    IssuerConfig::class => function (ContainerInterface $c) {
        return new IssuerConfig();
    },
    NFeConfig::class => function (ContainerInterface $c) {
        return new NFeConfig();
    }
];

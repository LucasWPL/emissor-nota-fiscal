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
        $tools = new Tools($c->get(NFeConfig::class)->getFileContents(), $c->get('certificate'));

        return new NFeSign($tools, $c->get(IssuerConfig::class), $c->get(NFeConfig::class));
    },
    'certificate' => function (ContainerInterface $c) {
        $certificateFIle = file_get_contents($c->get('cert.url'));
        $certificate = Certificate::readPfx($certificateFIle, $c->get('cert.pass'));

        return $certificate;
    },
    IssuerConfig::class => function (ContainerInterface $c) {
        return new IssuerConfig();
    },
    NFeConfig::class => function (ContainerInterface $c) {
        return new NFeConfig();
    }
];

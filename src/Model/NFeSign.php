<?php

namespace Lucas\EmissorNotaFiscal\Model;

use Lucas\EmissorNotaFiscal\Helper\IssuerConfig;
use Lucas\EmissorNotaFiscal\Helper\NFeConfig;
use NFePHP\NFe\Common\Tools;

class NFeSign
{
    private $tools;
    private $issuerConfig;
    private $config;

    public function __construct(
        Tools $tools,
        IssuerConfig $issuerConfig,
        NFeConfig $config
    ) {
        $this->tools = $tools;
        $this->issuerConfig = $issuerConfig;
        $this->config = $config;
    }

    public function sign($xml)
    {
        return $this->tools->signNFe($xml);
    }
}

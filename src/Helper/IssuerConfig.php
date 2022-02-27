<?php

namespace Lucas\EmissorNotaFiscal\Helper;

use Lucas\EmissorNotaFiscal\Helper\Interface\ConfigInterface;

class IssuerConfig implements ConfigInterface
{
    public $values;
    private $url = __DIR__ . "/../../config/settings/issuer.config.json";

    public function __construct()
    {
        $this->setValues();
    }

    public function setValues()
    {
        $json = file_get_contents($this->url);
        $this->values = json_decode($json);
    }
}

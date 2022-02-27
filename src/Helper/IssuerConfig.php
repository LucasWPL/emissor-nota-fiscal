<?php

namespace Lucas\EmissorNotaFiscal\Helper;

class IssuerConfig
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

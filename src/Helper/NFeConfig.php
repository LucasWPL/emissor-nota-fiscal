<?php

namespace Lucas\EmissorNotaFiscal\Helper;

use Lucas\EmissorNotaFiscal\Helper\Interface\ConfigInterface;

class NFeConfig implements ConfigInterface
{
    public $values;
    private $url = __DIR__ . "/../../config/settings/config.json";

    public function __construct()
    {
        $this->setValues();
    }

    public function getFileContents()
    {
        return file_get_contents($this->url);
    }

    public function setValues()
    {
        $json = $this->getFileContents();
        $this->values = json_decode($json);
    }
}

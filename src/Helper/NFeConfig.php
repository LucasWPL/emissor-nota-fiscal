<?php

namespace Lucas\EmissorNotaFiscal\Helper;

class NFeConfig
{
    public $values;
    private $url = __DIR__ . "/../../config/settings/config.json";

    public function __construct()
    {
        $this->getFileInfos();
    }

    private function getFileInfos()
    {
        $json = file_get_contents($this->url);
        $this->values = json_decode($json);
    }
}

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

    public function getFileContents()
    {
        return file_get_contents($this->url);
    }

    private function getFileInfos()
    {
        $json = $this->getFileContents();
        $this->values = json_decode($json);
    }
}

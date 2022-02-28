<?php

namespace Lucas\EmissorNotaFiscal\Model;

use Lucas\EmissorNotaFiscal\Helper\JsonResponser;
use NFePHP\NFe\Tools;

class NFeRequestAuthorization implements XmlBuilderInterface
{
    public $tools;
    private $chave;
    public $shouldSave = true;
    private $pathToSave = __DIR__ . "/../../data/xml/enviadas/";

    public function __construct(
        Tools $tools
    ) {
        $this->tools = $tools;
    }

    public function requestAuthorization($xml, $chave)
    {
        $this->chave = $chave;

        try {
            $xml = $this->tools->sefazEnviaLote([$xml], $this->getLoteNumber());
            $this->saveXml($xml);

            return JsonResponser::toJson(array(
                "message" => "Autorização requisitada com sucesso",
                "data" => array(
                    "xml" => $xml,
                    "chave" => $this->chave,
                ),
            ));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saveXml($content)
    {
        if (!$this->shouldSave) {
            return;
        }

        $filename = $this->pathToSave . "nfe-enviada-" . $this->chave . ".xml";
        file_put_contents($filename, $content);
    }

    public function alterXmlPath($url)
    {
        $this->pathToSave = $url;
    }

    public function getLoteNumber()
    {
        return intval(substr($this->chave, 25, 9));
    }
}

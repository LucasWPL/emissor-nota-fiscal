<?php

namespace Lucas\EmissorNotaFiscal\Model;

use Lucas\EmissorNotaFiscal\Helper\JsonResponser;
use NFePHP\NFe\Common\Tools;

class NFeSign implements XmlBuilderInterface
{
    private $tools;
    private $chave;
    public $shouldSave = true;
    private $pathToSave = __DIR__ . "/../../data/xml/assinados/";

    public function __construct(
        Tools $tools
    ) {
        $this->tools = $tools;
    }

    public function sign($xml, $chave)
    {
        $this->chave = $chave;

        try {
            $xml = $this->tools->signNFe($xml);
            $this->saveXml($xml);

            return JsonResponser::toJson(array(
                "message" => "XML assinado com sucesso",
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

        $filename = $this->pathToSave . "nfe-assinada-" . $this->chave . ".xml";
        file_put_contents($filename, $content);
    }

    public function alterXmlPath($url)
    {
        $this->pathToSave = $url;
    }
}

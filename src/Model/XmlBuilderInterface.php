<?php

namespace Lucas\EmissorNotaFiscal\Model;

interface XmlBuilderInterface
{
    public function alterXmlPath($url);
    public function saveXml($content);
}

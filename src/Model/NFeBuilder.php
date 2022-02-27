<?php

namespace Lucas\EmissorNotaFiscal\Model;

use Lucas\EmissorNotaFiscal\Helper\IssuerConfig;
use Lucas\EmissorNotaFiscal\Helper\NFeConfig;
use NFePHP\NFe\Make;

class NFeBuilder
{
    public $shouldSave = true;
    private $nfe;
    private $issuerConfig;
    private $values;
    private $pathToSave = __DIR__ . "/../../data/xml/";

    // valores padrões de campos
    private $dhEmi;
    private $mod = 55;
    private $serie = 1;
    private $versao = '4.00';

    public function __construct(
        Make $nfe,
        IssuerConfig $issuerConfig,
        NFeConfig $config
    ) {
        $this->nfe = $nfe;
        $this->issuerConfig = $issuerConfig;
        $this->config = $config;

        $this->setTime();
    }

    public function build(\stdClass $values)
    {
        $this->values = $values;

        $this->taginfNFe();
        $this->tagide();
        $this->tagrefNFe();
        $this->tagemit();
        $this->tagenderEmit();
        $this->tagdest();
        $this->tagenderDest();
        $this->tagautXML();
        $this->tagprod();

        try {
            $xml = $this->nfe->monta();
            $this->saveXml($xml);

            return json_encode(array(
                "message" => "XML criado com sucesso",
                "data" => array(
                    "xml" => $xml
                ),
            ));
        } catch (\Exception $e) {
            throw new \Exception(implode(" | ", $this->nfe->getErrors()), 1);
        }
    }

    public function alterXmlPath($url)
    {
        $this->pathToSave = $url;
    }

    private function saveXml($content)
    {
        if (!$this->shouldSave) return;

        $filename = $this->pathToSave . $this->nfe->getChave() . ".xml";
        $file = fopen($filename, "w");
        fwrite($file, $content);
        fclose($file);
    }

    private function tagprod()
    {
        foreach ($this->values->produtos as $produto) {
            $std = new \stdClass();
            $std->item = $produto->item;
            $std->cProd = $produto->cProd;
            $std->cEAN = $produto->cEAN;
            $std->cBarra = $produto->cBarra;
            $std->xProd = $produto->xProd;
            $std->NCM = $produto->NCM;
            $std->cBenef = $produto->cBenef;
            $std->EXTIPI = $produto->EXTIPI;
            $std->CFOP = $produto->CFOP;
            $std->uCom = $produto->uCom;
            $std->qCom = $produto->qCom;
            $std->vUnCom = $produto->vUnCom;
            $std->vProd = $produto->vProd;
            $std->cEANTrib = $produto->cEANTrib;
            $std->cBarraTrib = $produto->cBarraTrib;
            $std->uTrib = $produto->uTrib;
            $std->qTrib = $produto->qTrib;
            $std->vUnTrib = $produto->vUnTrib;
            $std->vFrete = $produto->vFrete;
            $std->vSeg = $produto->vSeg;
            $std->vDesc = $produto->vDesc;
            $std->vOutro = $produto->vOutro;
            $std->indTot = $produto->indTot;
            $std->xPed = $produto->xPed;
            $std->nItemPed = $produto->nItemPed;
            $std->nFCI = $produto->nFCI;
        }

        $this->nfe->tagprod($std);
    }

    private function tagautXML()
    {
        $std = new \stdClass();
        if (strlen($this->issuerConfig->values->CNPJ) == 11) {
            $std->CPF = $this->values->dest->CNPJ;
            $std->CNPJ = null;
        } else {
            $std->CNPJ = $this->values->dest->CNPJ;
            $std->CPF = null;
        }

        $this->nfe->tagautXML($std);
    }

    private function tagenderDest()
    {
        $std = new \stdClass();
        $std->xLgr = $this->values->dest->xLgr;
        $std->nro = $this->values->dest->nro;
        $std->xCpl = $this->values->dest->xCpl;
        $std->xBairro = $this->values->dest->xBairro;
        $std->cMun = $this->values->dest->cMun;
        $std->xMun = $this->values->dest->xMun;
        $std->UF = $this->values->dest->UF;
        $std->CEP = $this->values->dest->CEP;
        $std->cPais = $this->values->dest->cPais;
        $std->xPais = $this->values->dest->xPais;
        $std->fone = $this->values->dest->fone;

        $this->nfe->tagenderDest($std);
    }

    private function tagdest()
    {
        $std = new \stdClass();
        $std->xNome = $this->values->dest->xNome;
        $std->indIEDest = $this->values->dest->indIEDest;
        $std->IE = $this->values->dest->IE;
        $std->ISUF = $this->values->dest->ISUF;
        $std->IM = $this->values->dest->IM;
        $std->email = $this->values->dest->email;

        if (strlen($this->issuerConfig->values->CNPJ) == 11) {
            $std->CPF = $this->values->dest->CNPJ;
        } elseif (strlen($this->issuerConfig->values->CNPJ) == 14) {
            $std->CNPJ = $this->values->dest->CNPJ;
        } else {
            $std->idEstrangeiro = $this->values->dest->CNPJ;
        }

        $this->nfe->tagdest($std);
    }

    private function tagenderEmit()
    {
        $std = new \stdClass();
        $std->xLgr = $this->issuerConfig->values->endereco->xLgr;
        $std->nro = $this->issuerConfig->values->endereco->nro;
        $std->xCpl = $this->issuerConfig->values->endereco->xCpl;
        $std->xBairro = $this->issuerConfig->values->endereco->xBairro;
        $std->cMun = $this->issuerConfig->values->endereco->cMun;
        $std->xMun = $this->issuerConfig->values->endereco->xMun;
        $std->UF = $this->issuerConfig->values->endereco->UF;
        $std->CEP = $this->issuerConfig->values->endereco->CEP;
        $std->cPais = $this->issuerConfig->values->endereco->cPais;
        $std->xPais = $this->issuerConfig->values->endereco->xPais;
        $std->fone = $this->issuerConfig->values->endereco->fone;

        $this->nfe->tagenderEmit($std);
    }

    private function tagemit()
    {
        $std = new \stdClass();
        $std->xNome = $this->issuerConfig->values->xNome;
        $std->xFant = $this->issuerConfig->values->xFant;
        $std->IE = $this->issuerConfig->values->IE;
        $std->IEST = $this->issuerConfig->values->IEST;
        $std->IM = $this->issuerConfig->values->IM;
        $std->CNAE = $this->issuerConfig->values->CNAE;
        $std->CRT = $this->issuerConfig->values->CRT;

        if (strlen($this->issuerConfig->values->CNPJ) == 11) {
            $std->CPF = $this->issuerConfig->values->CNPJ;
        } else {
            $std->CNPJ = $this->issuerConfig->values->CNPJ;
        }

        $this->nfe->tagemit($std);
    }

    private function tagrefNFe()
    {
        $std = new \stdClass();
        $std->refNFe = $this->values->refNFe;

        $this->nfe->tagrefNFe($std);
    }

    private function taginfNFe()
    {
        $std = new \stdClass();
        $std->versao = $this->versao;
        $std->pk_nItem = $this->values->pk_nItem;

        $this->nfe->taginfNFe($std);
    }

    private function tagide()
    {
        $std = new \stdClass();
        $std->cUF = $this->issuerConfig->values->cUF;
        $std->cNF = $this->values->cNF;
        $std->natOp = $this->values->natOp;

        //$std->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00

        $std->mod = $this->mod;
        $std->serie = $this->serie;
        $std->nNF = $this->values->nNF;
        $std->dhEmi = $this->dhEmi;
        $std->dhSaiEnt = $this->values->dhSaiEnt;
        $std->tpNF = $this->values->tpNF;
        $std->idDest = $this->values->idDest;
        $std->cMunFG = $this->issuerConfig->values->cMun;
        $std->tpImp = $this->values->tpImp;
        $std->tpEmis = $this->values->tpEmis;
        $std->cDV = $this->values->cDV;
        $std->tpAmb = $this->config->values->tpAmb;
        $std->finNFe = $this->values->finNFe;
        $std->indFinal = $this->values->indFinal;
        $std->indPres = $this->values->indPres;
        $std->indIntermed = $this->values->indIntermed;
        $std->procEmi = $this->values->procEmi;
        $std->verProc = '3.10.31';
        $std->dhCont = $this->values->dhCont;
        $std->xJust = $this->values->xJust;

        $this->nfe->tagide($std);
    }

    private function setTime()
    {
        $dtzReff = new \DateTimeZone("Europe/Lisbon");
        $dtReff = new \DateTime("now", $dtzReff);

        $dtz = new \DateTimeZone($this->issuerConfig->values->timezone);
        $dt = new \DateTime("now", $dtz);

        $hour = abs(
            strtotime($dt->format("Y-m-d H:i:s")) - strtotime($dtReff->format("Y-m-d H:i:s"))
        ) / (60 * 60);

        $diffTimeZone = "-" . str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00";

        $this->dhEmi = $dt->format("Y-m-d") . "T" . $dt->format("H:i:s") . $diffTimeZone;
    }
}

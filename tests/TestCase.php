<?php

namespace Lucas\EmissorNotaFiscal\Test;

use Lucas\EmissorNotaFiscal\Model\NFeBuilder;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

abstract class TestCase extends FrameworkTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->container = require __DIR__ . "/../config/container.config.php";
        $this->nfeBuilder = $this->container->get(NFeBuilder::class);
        $this->nfeBuilder->alterXmlPath(__DIR__ . "/data/");
    }

    public function notaFiscal()
    {
        $blocos = [];

        $tagInfNfe = [
            'pk_nItem' => null
        ];
        $blocos[] = $tagInfNfe;

        $tagIde = [
            "cNF" => "00000001",
            "natOp" => "VENDA",
            "nNF" => 2,
            "dhSaiEnt" => null,
            "tpNF" => 1,
            "idDest" => 1,
            "tpImp" => 1,
            "tpEmis" => 1,
            "cDV" => 2,
            "finNFe" => 1,
            "indFinal" => 0,
            "indPres" => 0,
            "indIntermed" => null,
            "procEmi" => 0,
            "dhCont" => null,
            "xJust" => null,
        ];
        $blocos[] = $tagIde;

        $tagRefNfe = [
            'refNFe' => null
        ];
        $blocos[] = $tagRefNfe;

        $tagDestAndEndereco = [
            "dest" => [
                'xNome' => "Comprador LTDA",
                'indIEDest' => "2",
                'IE' => null,
                'ISUF' => null,
                'IM' => "00000001",
                'email' => "email@example.com",
                'CNPJ' => "00716345000123",
                //endereco
                'xLgr' => "Rua Orial Frere Marcelino",
                'nro' => "999",
                'xCpl' => "Longe da esquina",
                'xBairro' => "Bom grado",
                'cMun' => "2304400",
                'xMun' => "Fortaleza",
                'UF' => "CE",
                'CEP' => "63575000",
                'cPais' => "1058",
                'xPais' => "Brasil",
                'fone' => "85999999999",
            ]
        ];
        $blocos[] = $tagDestAndEndereco;

        $tagProdutos = [
            "produtos" => [
                [
                    "item" => 1,
                    "cProd" => "010203",
                    "cEAN" => null,
                    "cBarra" => null,
                    "xProd" => "Memória 8 gb",
                    "NCM" => "85423221",
                    "cBenef" => null,
                    "EXTIPI" => null,
                    "CFOP" => '6102',
                    "uCom" => "UND",
                    "qCom" => 10,
                    "vUnCom" => 284.10,
                    "vProd" => 2841.10,
                    "cEANTrib" => null,
                    "cBarraTrib" => null,
                    "uTrib" => 'UND',
                    "qTrib" => 10,
                    "vUnTrib" => 284.11,
                    "vFrete" => null,
                    "vSeg" => null,
                    "vDesc" => null,
                    "vOutro" => null,
                    "indTot" => 1,
                    "xPed" => null,
                    "nItemPed" => null,
                    "nFCI" => null,
                ]
            ]
        ];
        $blocos[] = $tagProdutos;

        $tagICMS = [
            "icms" => [
                1 => [
                    "item" => 1,
                    "vBC" => 2841.10, //total produto
                    "pICMS" => 12, // percentual sob o vBC
                    "vICMS" => 340.932,
                    "CST" => "00",
                    "orig" => "0",
                    "modBC" => "0",
                ]
            ]
        ];
        $blocos[] = $tagICMS;

        $tagPag = [
            "pag" => [
                "vTroco" => null,
            ]
        ];
        $blocos[] = $tagPag;

        $tagDetPag = [
            "detPag" => [
                "indPag" => 0,
                "tPag" => "03",
                "vPag" => 2841.10,
            ]
        ];
        $blocos[] = $tagDetPag;

        $values = $this->toJson(array_merge(...$blocos));

        return array(
            array($values)
        );
    }

    private function toJson($array)
    {
        return json_decode(json_encode($array));
    }
}

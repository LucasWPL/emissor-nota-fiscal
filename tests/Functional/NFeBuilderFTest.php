<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;

use Lucas\EmissorNotaFiscal\Model\NFeBuilder;
use Lucas\EmissorNotaFiscal\Test\TestCase;

use function PHPUnit\Framework\assertEquals;

class NFeBuilderFTest extends TestCase
{
    private $builder;

    public function setUp(): void
    {
        parent::setUp();
        $this->builder = $this->container->get(NFeBuilder::class);
        $this->builder->alterXmlPath(__DIR__ . "/../data/");
    }

    /**
     * @dataProvider provider
     */
    public function testBuildSuccess($values)
    {
        $result = json_decode($this->builder->build($values));
        assertEquals("XML criado com sucesso", $result->message);
    }

    public function provider()
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
            "dest" => (object) [
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
                (object) [
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
                    "vUnCom" => 100.00,
                    "vProd" => 120.00,
                    "cEANTrib" => null,
                    "cBarraTrib" => null,
                    "uTrib" => 'UND',
                    "qTrib" => 10,
                    "vUnTrib" => 100.00,
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

        $values = (object) array_merge(...$blocos);

        return array(
            array($values)
        );
    }
}

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

        $tagDest = [
            "dest" => (object) [
                'xNome' => "Comprador LTDA",
                'indIEDest' => "2",
                'IE' => null,
                'ISUF' => null,
                'IM' => "00000001",
                'email' => "email@example.com",
                'CNPJ' => "00716345000123"
            ]
        ];
        $blocos[] = $tagDest;

        $values = (object) array_merge(...$blocos);

        return array(
            array($values)
        );
    }
}

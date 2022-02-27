<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;


use Lucas\EmissorNotaFiscal\Model\NFeSign;
use Lucas\EmissorNotaFiscal\Test\TestCase;

use function PHPUnit\Framework\assertEquals;

class NFeSignFTest extends TestCase
{
    private $nfeSign;

    public function setUp(): void
    {
        parent::setUp();
        $this->nfeSign = $this->container->get(NFeSign::class);
        $this->nfeBuilder->shouldSave = false;
    }

    /**
     * @dataProvider notaFiscal
     */
    public function testBuildSuccess($values)
    {
        $result = json_decode($this->nfeBuilder->build($values));
        $this->nfeSign->sign($result->data->xml);

        assertEquals("XML criado com sucesso", $result->message);
    }
}

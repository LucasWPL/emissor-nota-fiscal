<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;

use Lucas\EmissorNotaFiscal\Test\TestCase;
use function PHPUnit\Framework\assertEquals;

class NFeSignFTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->nfeBuilder->shouldSave = false;
    }

    /**
     * @dataProvider notaFiscal
     */
    public function testBuildSuccess($values)
    {
        $result = $this->nfeBuilder->build($values);
        $resultSign = $this->nfeSign->sign(
            $result->data->xml,
            $result->data->chave
        );

        assertEquals("XML criado com sucesso", $result->message);
        assertEquals("XML assinado com sucesso", $resultSign->message);
    }
}

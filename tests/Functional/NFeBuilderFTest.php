<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;

use Lucas\EmissorNotaFiscal\Test\TestCase;

use function PHPUnit\Framework\assertEquals;

class NFeBuilderFTest extends TestCase
{
    /**
     * @dataProvider notaFiscal
     */
    public function testBuildSuccess($values)
    {
        $result = $this->nfeBuilder->build($values);
        assertEquals("XML criado com sucesso", $result->message);
    }
}

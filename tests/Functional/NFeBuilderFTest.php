<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;

use Lucas\EmissorNotaFiscal\Model\NFeBuilder;
use Lucas\EmissorNotaFiscal\Test\TestCase;

use function PHPUnit\Framework\assertEquals;

class NFeBuilderFTest extends TestCase
{
    private $builder;
    /**
     * @dataProvider notaFiscal
     */
    public function testBuildSuccess($values)
    {
        $result = json_decode($this->builder->build($values));
        assertEquals("XML criado com sucesso", $result->message);
    }
}

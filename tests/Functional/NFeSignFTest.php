<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;

use Lucas\EmissorNotaFiscal\Model\NFeBuilder;
use Lucas\EmissorNotaFiscal\Model\NFeSign;
use Lucas\EmissorNotaFiscal\Test\TestCase;
use NFePHP\Common\Certificate;

use function PHPUnit\Framework\assertEquals;

class NFeSignFTest extends TestCase
{
    private $nfeSign;
    private $builder;
    private $container;

    public function setUp(): void
    {
        parent::setUp();
        $this->nfeSign = $this->container->get(NFeSign::class);
        $this->builder->shouldSave = false;
    }

    /**
     * @dataProvider notaFiscal
     */
    public function testBuildSuccess($values)
    {
        $result = json_decode($this->builder->build($values));
        $this->nfeSign->sign($result->data->xml);

        assertEquals("XML criado com sucesso", $result->message);
    }
}

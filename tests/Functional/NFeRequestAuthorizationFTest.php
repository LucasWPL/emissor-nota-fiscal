<?php

namespace Lucas\EmissorNotaFiscal\Test\Functional;

use Lucas\EmissorNotaFiscal\Test\TestCase;
use function PHPUnit\Framework\assertEquals;

class NFeRequestAuthorizationFTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->nfeBuilder->shouldSave = false;
        $this->nfeSign->shouldSave = false;
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
        $resultAuthorization = $this->nfeAuthorization->requestAuthorization(
            $resultSign->data->xml,
            $result->data->chave
        );
        var_dump($resultAuthorization);
        exit;

        assertEquals("XML criado com sucesso", $result->message);
        assertEquals("XML assinado com sucesso", $resultSign->message);
        assertEquals("NF-e foi aturorizada com sucesso", $resultAuthorization->message);
    }
}

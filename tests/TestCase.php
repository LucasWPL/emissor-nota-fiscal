<?php

namespace Lucas\EmissorNotaFiscal\Test;

use PHPUnit\Framework\TestCase as FrameworkTestCase;

abstract class TestCase extends FrameworkTestCase
{

    public function setUp(): void
    {
        $this->container = require_once __DIR__ . "/../config/container.config.php";
    }
}

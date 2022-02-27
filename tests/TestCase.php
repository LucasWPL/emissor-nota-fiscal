<?php

namespace Lucas\EmissorNotaFiscal\Test;

use PHPUnit\Framework\TestCase as FrameworkTestCase;

abstract class TestCase extends FrameworkTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->container = require_once __DIR__ . "/../config/container.config.php";
    }
}

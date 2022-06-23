<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class GentreeTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');
    }
}
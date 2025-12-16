<?php

namespace DavidGut\SimpleAuth\Tests;

use DavidGut\SimpleAuth\SimpleAuthServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            SimpleAuthServiceProvider::class,
        ];
    }
}

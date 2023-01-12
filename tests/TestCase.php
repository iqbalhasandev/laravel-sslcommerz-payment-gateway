<?php

namespace Nanopkg\SslcommerzPaymentGateway\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nanopkg\SslcommerzPaymentGateway\SslcommerzPaymentGatewayServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    protected function getPackageProviders($app)
    {
        return [
            SslcommerzPaymentGatewayServiceProvider::class,
        ];
    }
}

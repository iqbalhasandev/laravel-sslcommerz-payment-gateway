<?php

namespace Nanopkg\SslcommerzPaymentGateway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nanopkg\SslcommerzPaymentGateway\SslcommerzPaymentGateway
 */
class Sslcommerz extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Nanopkg\SslcommerzPaymentGateway\Sslcommerz::class;
    }
}

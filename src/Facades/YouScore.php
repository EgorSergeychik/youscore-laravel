<?php

namespace EgorSergeychik\YouScore\Facades;

use EgorSergeychik\YouScore\Client;
use Illuminate\Support\Facades\Facade;

class YouScore extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
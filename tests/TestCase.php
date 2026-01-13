<?php

namespace EgorSergeychik\YouScore\Tests;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as Orchestra;
use EgorSergeychik\YouScore\YouScoreServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    protected function getPackageProviders($app): array
    {
        return [
            YouScoreServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('youscore.polling.delay', 0);
        $app['config']->set('youscore.polling.enabled', true);
        $app['config']->set('youscore.polling.max_attempts', 3);
    }
}

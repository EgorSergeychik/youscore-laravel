<?php

namespace EgorSergeychik\YouScore;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class YouScoreServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/youscore.php', 'youscore'
        );

        $this->app->singleton(Client::class, function ($app) {
            $config = $app['config']['youscore'];

            return new Client(
                baseUrl: $config['base_url'],
                apiKey: $config['api_key'],
                timeout: $config['timeout'] ?? 30,
                pollingConfig: $config['polling'] ?? ['enabled' => false, 'max_attempts' => 1, 'delay' => 1000],
            );
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/youscore.php' => config_path('youscore.php'),
            ], 'youscore-config');
        }
    }

    public function provides(): array
    {
        return [Client::class];
    }
}

<?php

declare(strict_types=1);

namespace Leek\CompactLogs;

use Illuminate\Support\ServiceProvider;

class CompactLogsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/compact-logs.php', 'compact-logs');

        $channels = config('compact-logs.channels');

        if (! is_array($channels)) {
            return;
        }

        foreach ($channels as $channel) {
            $key = "logging.channels.{$channel}.tap";
            $existing = config($key, []);

            if (! in_array(CompactExceptionTap::class, $existing)) {
                config([$key => array_merge($existing, [CompactExceptionTap::class])]);
            }
        }
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/compact-logs.php' => config_path('compact-logs.php'),
            ], 'compact-logs-config');
        }
    }
}

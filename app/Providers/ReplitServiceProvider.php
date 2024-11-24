<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReplitServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS', 'on');
            
            if ($this->app->request->header('X-Forwarded-Proto') === 'https') {
                $this->app['url']->forceScheme('https');
            }
        }
    }

    public function boot()
    {
        if ($host = $this->app->request->header('X-Forwarded-Host')) {
            $this->app['url']->forceRootUrl("https://{$host}");
        }
    }
}

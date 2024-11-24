<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class ReplitServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('local', 'production')) {
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
            
            if ($replSlug = env('REPL_SLUG')) {
                $replOwner = env('REPL_OWNER');
                $host = "{$replSlug}.{$replOwner}.repl.co";
                URL::forceRootUrl("https://{$host}");
            }
        }
    }

    public function boot()
    {
        // Trust the Replit proxy
        $this->app['request']->server->set('HTTPS', 'on');
        
        if ($host = $this->app->request->header('X-Forwarded-Host')) {
            URL::forceRootUrl("https://{$host}");
        }
    }
}

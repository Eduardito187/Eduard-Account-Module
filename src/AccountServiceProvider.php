<?php

namespace Eduard\Account;

use Eduard\Account\Console\Commands\BackupDB;
use Eduard\Account\Console\Commands\JobRestorePassword;
use Eduard\Account\Console\Commands\JobRestorePasswordConfirm;
use Eduard\Account\Console\Commands\JobSaveHistoryCustomerUuid;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Eduard\Account\Events\HistoryCustomerUuid;
use Eduard\Account\Http\Middleware\AdminValidateToken;
use Eduard\Account\Http\Middleware\CustomValidateToken;
use Eduard\Account\Listeners\SaveHistoryCustomerUuid;

class AccountServiceProvider extends ServiceProvider
{
    protected $commands = [
        BackupDB::class,
        JobRestorePassword::class,
        JobRestorePasswordConfirm::class,
        JobSaveHistoryCustomerUuid::class,
    ];

    protected $listen = [
        HistoryCustomerUuid::class => [
            SaveHistoryCustomerUuid::class,
        ],
    ];

    public function register()
    {
        // Register package's services here
    }

    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/./database/migrations');

        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/logging.php' => config_path('logging.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        // Load API routes
        $this->loadRoutesFrom(__DIR__.'/Http/routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/Http/routes/web.php');

        // Register middleware
        $this->app['router']->aliasMiddleware('custom.token', CustomValidateToken::class);
        $this->app['router']->aliasMiddleware('admin.token', AdminValidateToken::class);

        // Register events dynamically (optional)
        Event::listen(HistoryCustomerUuid::class, SaveHistoryCustomerUuid::class);
    }
}

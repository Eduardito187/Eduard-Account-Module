<?php

namespace Eduard\Account;

use Eduard\Account\Console\Commands\BackupDB;
use Eduard\Account\Console\Commands\JobRestorePassword;
use Eduard\Account\Console\Commands\JobRestorePasswordConfirm;
use Eduard\Account\Console\Commands\JobSaveHistoryCustomerUuid;
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
        JobSaveHistoryCustomerUuid::class
    ];

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        HistoryCustomerUuid::class => [
            SaveHistoryCustomerUuid::class
        ]
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register package's services here
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes, migrations, etc.
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->publishes([
            __DIR__.'/../config/logging.php' => config_path('logging.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        // Load API routes
        $this->loadRoutesFrom(__DIR__.'/Http/routes/api.php');

        // Registrar middleware
        $this->app['router']->aliasMiddleware('custom.token', CustomValidateToken::class);
        $this->app['router']->aliasMiddleware('admin.token', AdminValidateToken::class);
    }
}
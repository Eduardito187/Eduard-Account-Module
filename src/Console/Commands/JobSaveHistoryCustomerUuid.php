<?php

namespace Eduard\Account\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class JobSaveHistoryCustomerUuid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobSaveHistoryCustomerUuid:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute proccess jobs.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        exec("php artisan queue:work database --queue=save_history_customer_uuid --stop-when-empty");
        return Command::SUCCESS;
    }
}
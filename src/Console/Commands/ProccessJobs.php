<?php

namespace Eduard\Account\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProccessJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proccessJobs:cron';

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
        return Command::SUCCESS;
    }
}
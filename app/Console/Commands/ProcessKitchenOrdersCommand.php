<?php

namespace App\Console\Commands;

use App\Jobs\ProcessKitchenOrders;
use Illuminate\Console\Command;

class ProcessKitchenOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-kitchen-orders-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders send to kitchen on time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ProcessKitchenOrders::dispatch();
    }
}

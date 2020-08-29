<?php

namespace App\Console\Commands;

use App\Jobs\SetCompletedOrdersStatusToDone;
use App\Production;
use Illuminate\Console\Command;

class OrdersCheckProduced extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check_produced';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = now();
        $productionsCount = Production::where('end_at', '<=', $date->format('Y-m-d H:i:s'))
            ->where('end_at', '>', $date->subHour()->format('Y-m-d H:i:s'))
            ->count();

        $this->info('Productions to be processed: ' . $productionsCount);

        for ($i = 0; $i < $productionsCount; $i += 100) {
            dispatch(new SetCompletedOrdersStatusToDone(100, $i));
        }
    }
}

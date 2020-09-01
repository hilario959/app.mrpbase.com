<?php

namespace App\Console\Commands;

use App\Jobs\SetOrdersStatusToDone;
use App\Jobs\SetOrdersStatusToProgress;
use App\Production;
use Illuminate\Console\Command;

class ProductionsProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productions:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process productions';

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
        $productionsStartCount = Production::where('end_at', '<', $date->format('Y-m-d H:i:s'))
            ->where('start_at', '>=', $date->subHour()->format('Y-m-d H:i:s'))
            ->count();

        $this->info('Productions in progress: ' . $productionsStartCount);

        for ($i = 0; $i < $productionsStartCount; $i += 100) {
            dispatch(new SetOrdersStatusToProgress(100, $i));
        }

        $productionsCount = Production::where('end_at', '>', $date->subHour()->format('Y-m-d H:i:s'))
            ->count();

        $this->info('Productions completed: ' . $productionsCount);

        for ($i = 0; $i < $productionsCount; $i += 100) {
            dispatch(new SetOrdersStatusToDone(100, $i));
        }
    }
}

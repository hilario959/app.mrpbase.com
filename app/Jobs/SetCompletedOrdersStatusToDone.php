<?php

namespace App\Jobs;

use App\Order;
use App\Production;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetCompletedOrdersStatusToDone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $limit;
    private $offset;

    /**
     * Create a new job instance.
     *
     * @param $limit
     * @param $offset
     */
    public function __construct($limit, $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = now();
        $productions = Production::where('end_at', '<=', $date->format('Y-m-d H:i:s'))
            ->where('end_at', '>', $date->subHour()->format('Y-m-d H:i:s'))
            ->limit($this->limit)
            ->offset($this->offset)
            ->with(['products' => function ($query) {
                $query->groupBy('order_id');
            }, 'products.order.products' => function ($query) {
                $query->wherePivot('remaining_quantity', '>', 0);
            }])
            ->get();

        foreach ($productions as $production) {
            foreach ($production->products as $item) {
                if ($item->order->status === Order::STATUS_DONE) {
                    continue;
                }

                if ($item->order->products->isEmpty()) {
                    $item->order->update(['status' => Order::STATUS_DONE]);
                }
            }
        }
    }
}

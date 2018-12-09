<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Order;
use Illuminate\Support\Facades\DB;

class SetExpiredOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order_no;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_no)
    {
        $this->order_no = $order_no;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order_no = $this->order_no;
        $order = Order::where('order_no', $order_no)->first();
        DB::beginTransaction();
        try {
            $order->update([
                'status' => 'canceled',
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }
}

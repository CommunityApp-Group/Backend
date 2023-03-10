<?php

namespace App\Jobs;

use App\Repositories\Order\OrderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderplacedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param OrderInterface $neworder
     * @return void
     */
    public function handle(OrderInterface $neworder )
    {
        $neworder->sendToUser($this->order);
        $neworder->sendToAdmin($this->order);
    }
}

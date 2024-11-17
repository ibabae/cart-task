<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClearCartJob implements ShouldQueue
{
    use Queueable;

    protected $cart;
    /**
     * Create a new job instance.
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->cart->delete();
    }
}

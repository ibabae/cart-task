<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $textContent = "
            <div>New product has been created:</div>
            <div>Title: {$this->product->title}</div>
            <div>Price: {$this->product->price}</div>
            <div>Stock: {$this->product->stock}</div>
        ";

        return $this->subject('New Product Created')
                    ->html($textContent);
    }
}

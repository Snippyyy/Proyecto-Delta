<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductIsDeletedAdviceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $product_name;
    public $product_user_name;

    public function __construct(string $product_name, string $username, string $product_user_name)
    {
        $this->product_name = $product_name;
        $this->username = $username;
        $this->product_user_name = $product_user_name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'El producto que tenias en el carrito se ha borrado',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.product-is-deleted-advice',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

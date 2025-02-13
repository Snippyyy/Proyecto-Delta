<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductIsSoldAdviceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $username;

    public function __construct(Product $product, string $username)
    {
        $this->product = $product;
        $this->username = $username;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'El producto que tenias en tu carrito ha sido vendido',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.product-is-sold-advice',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

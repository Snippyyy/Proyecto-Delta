<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuccessfulPurchaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct( Order $order )
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Compra realizada con éxito',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.successful-purchase',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice for Order #ORD-' . str_pad($this->order->id, 5, '0', STR_PAD_LEFT),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_invoice',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('orders.pdf_invoice', ['order' => $this->order]);
        
        return [
            Attachment::fromData(fn () => $pdf->output(), 'Invoice-ORD-' . str_pad($this->order->id, 5, '0', STR_PAD_LEFT) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}

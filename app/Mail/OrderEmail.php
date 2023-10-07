<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\ProductInOrder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $order;
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $return_date = new Carbon($this->order->expected_return_date);
        $pick_up_date = new Carbon($this->order->expected_pick_up_date);
        $rent_time = $return_date->diffInDays($pick_up_date);

        return new Content(
            view: 'mail.order_email',
            with: [
                'order' => $this->order,
                'rent_time' => $rent_time,
                ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Common\Components\Mail;

use App\Common\Models\Catalog\Document\DocumentOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyOrder extends Mailable
{
    use Queueable, SerializesModels;

    public ?DocumentOrder $model = null;

    public function __construct(DocumentOrder $order)
    {
        $this->model = $order;
    }

    public function build()
    {
        return $this->view('mail.notify_order');
    }
}

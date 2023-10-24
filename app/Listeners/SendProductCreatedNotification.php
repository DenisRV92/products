<?php

namespace App\Listeners;

use App\Notifications\ProductCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\AnonymousNotifiable;

class SendProductCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $email = config('products.email');
        (new AnonymousNotifiable)->route('mail', $email)->notify(new ProductCreatedNotification($event->product));
    }
}

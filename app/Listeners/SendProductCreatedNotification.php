<?php

namespace App\Listeners;

use App\Notifications\ProductCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user(); // Здесь вы можете определить, кто будет получать уведомление. В данном случае первый пользователь в базе данных
        $user->notify(new ProductCreatedNotification($event->product));
    }
}

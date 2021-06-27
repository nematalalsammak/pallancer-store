<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;
    //protected $order_item;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    /*public function __construct(OrderItem $orderItem)
    {
        $this->order_item=$orderItem;
    }*/

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Order')
                    ->greeting('Hello, '. $notifiable->name)
                    ->line('A new order has been created.')
                    ->action('View Order', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return[
            'title'=>'New Order',
            'body'=>'A new order has been created.',
            'action'=>url('/'),
            'order_id'=>$this->order->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

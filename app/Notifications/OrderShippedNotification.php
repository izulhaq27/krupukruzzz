<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification
{
    // app/Notifications/OrderShippedNotification.php
public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('🚚 Pesanan Anda Sedang Dikirim - ' . $this->order->order_number)
        ->greeting('Halo ' . $notifiable->name . '!')
        ->line('Pesanan Anda dengan nomor **' . $this->order->order_number . '** sedang dalam pengiriman.')
        ->line('**Informasi Pengiriman:**')
        ->line('- Kurir: ' . strtoupper($this->order->shipping_courier))
        ->line('- Nomor Resi: ' . $this->order->tracking_number)
        ->line('- Estimasi Tiba: ' . $this->order->estimated_delivery->format('d M Y'))
        ->action('Lacak Paket', $this->order->tracking_link)
        ->line('Terima kasih telah berbelanja di KrupuKruzzz!');
}
}

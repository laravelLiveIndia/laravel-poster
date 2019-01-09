<?php

namespace Laravellive\Poster\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;
use NotificationChannels\FacebookPoster\FacebookPosterChannel;
use NotificationChannels\FacebookPoster\FacebookPosterPost;
use Illuminate\Support\Facades\Storage;

class PosterNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->content = $data->content;
        $this->via     = $data->via;
        $this->image   = Storage::url(str_replace('public/', '', $data->image_path));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];
        if (in_array('twitter', $this->via)) {
            $channels[] = TwitterChannel::class;
        }
        if (in_array('facebook', $this->via)) {
            $channels[] = FacebookPosterChannel::class;
        }

        // if (in_array('flock', $this->via)) {
        //     $channels[] = F::class;
        // }

        return $channels;
    }

    public function toTwitter($notifiable)
    {
        if ($this->image) {
            return (new TwitterStatusUpdate($this->content))->withImage(public_path($this->image));
        }
        return new TwitterStatusUpdate($this->content);
    }

    public function toFacebookPoster($notifiable)
    {
        if ($this->image) {
            return (new FacebookPosterPost($this->content))->withImage(url($this->image));
        }
        return new FacebookPosterPost($this->content);
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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

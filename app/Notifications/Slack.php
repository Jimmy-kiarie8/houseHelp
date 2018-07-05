<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Slack extends Notification {
	use Queueable;

	public $thread;
	public $authUser;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($thread, $authUser) {
		$this->thread = $thread;
		$this->authUser = $authUser;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) {
		return ['database'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toDatabase($notifiable) {
		return [
			// 'repliedTime'=>Carbon::now()
			'thread' => $this->thread,
			'authUser' => $this->authUser,
			'user' => $notifiable,
		];
	}

	/**
	 * Get the broadcastable representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return BroadcastMessage
	 */
	public function toBroadcast($notifiable)
	{
	    return new BroadcastMessage([
	        'thread' => $this->thread,
			'authUser' => $this->authUser,
			'user' => $notifiable,
	    ]);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable) {
		return [
			//
		];
	}
}

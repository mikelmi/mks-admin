<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 25.08.16
 * Time: 17:44
 */

namespace Mikelmi\MksAdmin\Notifications;


use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetAdminPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->view('admin::email')
            ->subject(__('admin::passwords.subject'))
            ->line(__('admin::passwords.mail_text'))
            ->action(__('admin::auth.Reset Password'), route('admin.reset', $this->token))
            ->line(__('admin::passwords.mail_note'));
    }
}
